<?php
namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Repositories\StudentRepository;
use Carbon\Carbon;


class StudentService
{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

   public function updateInfoText($student, array $data)
    {
        // Cập nhật name, phone
        $student->name = $data['name'];
        $student->phone = $data['phone'];
        $student->save();

        return $student;
    }

    public function updateAvatar($student, string $avatarUrl)
    {
        $student->avatar = $avatarUrl;
        $student->save();

        return $student;
    }
   
    public function changePassword($student, array $data)
    {
        if (!Hash::check($data['current_password'], $student->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect'],
            ]);
        }

        $hashedPassword = Hash::make($data['new_password']);

        return $this->studentRepository->changePassword($student, $hashedPassword);
    }

    public function getLearningJournal($studentId, $weekNumber)
    {
        $studentSubjects = $this->studentRepository->getStudentSubjects($studentId);
        $subjectMap = $studentSubjects->pluck('subject.name', 'subject_id')->toArray();

        $learningJournals = $this->studentRepository->getLearningJournals($studentId, $weekNumber);

        $learningJournalIds = $learningJournals->pluck('learning_journal_id')->toArray();

        $inClassRecords = $this->studentRepository->getInClassRecords($learningJournalIds);
        $inClassData = $inClassRecords->map(function ($record) use ($learningJournals, $subjectMap) {
            $learningJournal = $learningJournals->firstWhere('learning_journal_id', $record->learning_journal_id);
            $subjectName = $learningJournal->subject_name ?? 'Unknown';

            return [
                'date' => $record->date ?? '',
                'skills_module' => $subjectName, // <- đây là chỗ hiển thị
                'my_lesson' => $record->my_lesson ?? '',
                'self_assessment' => $record->self_assessment ?? '',
                'my_difficulties' => $record->difficulties ?? '',
                'my_plan' => $record->plan ?? '',
                'problem_solved' => $record->isSolved ? 'Yes' : 'No',
        ];
        })->values();

        $selfStudyRecords = $this->studentRepository->getSelfStudyRecords($learningJournalIds);
        $selfStudyData = $selfStudyRecords->map(function ($record) use ($learningJournals) {
            $learningJournal = $learningJournals->firstWhere('learning_journal_id', $record->learning_journal_id);
            $subjectName = $learningJournal->subject_name ?? 'Unknown';

            return [
                'date' => $record->date ?? '',
                'skills_module' => $subjectName, 
                'my_lesson' => $record->my_lesson ?? '',
                'time_allocation' => $record->time_allocation ?? '',
                'learning_resources' => $record->learning_resources ?? '',
                'learning_activities' => $record->learning_activities ?? '',
                'concentration' => $record->isConcentration ? 'Yes' : 'No',
                'plan_follow' => $record->isFollowPlan ? 'Yes' : 'No',
                'evaluation' => $record->evaluation ?? '',
                'reinforcing' => $record->reinforcing ?? '',
                'notes' => $record->note ?? '',
            ];
        })->values();

        $startDate = $learningJournals->min('start_date') ?? '';
        $endDate = $learningJournals->max('end_date') ?? '';

        return [
            'in_class' => $inClassData,
            'self_study' => $selfStudyData,
            'start_date' => $startDate,
            'end_date' => $endDate,
    
        ];
    }

    public function calculateWeekStartAndEndDate(int $studentId, int $weekNumber): array
    {
        $journals = $this->studentRepository->getJournalsByWeekAndStudent($weekNumber, $studentId);

        if ($journals->isNotEmpty()) {
            return [
                'start_date' => $journals->min('start_date'),
                'end_date' => $journals->max('end_date'),
            ];
        }

        $latestJournalWithData = $this->studentRepository->getPreviousJournal($studentId, $weekNumber);

        if ($latestJournalWithData) {
            $baseWeekNumber = $latestJournalWithData->week_number;
            $baseEndDate = Carbon::parse($latestJournalWithData->end_date);
            $weekDiff = $weekNumber - $baseWeekNumber;
            $startDate = $baseEndDate->addDays(1 + ($weekDiff - 1) * 7)->toDateString();
        } else {
            $startDate = Carbon::now()->startOfWeek()->toDateString();
        }

        $endDate = Carbon::parse($startDate)->addDays(6)->toDateString();

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }

    public function saveLearningJournal($studentId, $data)
    {
        $weekNumber = $data['week_number'];
        $learningJournals = $this->studentRepository->getLearningJournals($studentId, $weekNumber);
        $studentSubjects = $this->studentRepository->getStudentSubjects($studentId);

        $subjectMap = $studentSubjects->mapWithKeys(function ($item) {
            return [$item->subject->name => $item];
        });

        $lastSemester = $learningJournals->first()?->semester;

        if (!$lastSemester) {
            for ($prevWeek = $weekNumber - 1; $prevWeek > 0; $prevWeek--) {
                $prevJournals = $this->studentRepository->getLearningJournals($studentId, $prevWeek);
                if ($prevJournals->isNotEmpty()) {
                    $lastSemester = $prevJournals->first()->semester;
                    break;
                }
            }

            if (!$lastSemester) {
                $lastSemester = 3; 
            }
        }

        $dates = $this->calculateWeekStartAndEndDate($studentId, $weekNumber);
        $defaultStartDate = $dates['start_date'];
        $defaultEndDate = $dates['end_date'];

        // -------- XỬ LÝ IN-CLASS JOURNALS --------
        if (!empty($data['in_class']) && is_array($data['in_class'])) {
            foreach ($data['in_class'] as $inClass) {
                $skillsModule = $inClass['skills_module'];
                $studentSubject = $subjectMap[$skillsModule] ?? null;

                if (!$studentSubject) {
                    throw new \Exception('Không tìm thấy student_subject cho môn học: ' . $skillsModule);
                }

                $existingJournal = $learningJournals->first(function ($journal) use ($studentSubject, $weekNumber) {
                    return $journal->student_subject_id == $studentSubject->id && $journal->week_number == $weekNumber;
                });

                if (!$existingJournal) {
                    $existingJournal = $this->studentRepository->createLearningJournal([
                        'student_subject_id' => $studentSubject->id,
                        'semester' => $lastSemester,
                        'week_number' => $weekNumber,
                        'start_date' => $defaultStartDate,
                        'end_date' => $defaultEndDate,
                    ]);
                    $learningJournals->push($existingJournal);
                }

                // Kiểm tra ngày học (date) hợp lệ: trong khoảng start_date đến end_date
                $lessonDate = Carbon::parse($inClass['date']);
                if ($lessonDate->lt(Carbon::parse($existingJournal->start_date)) || $lessonDate->gt(Carbon::parse($existingJournal->end_date))) {
                    throw new \Exception("Ngày học {$inClass['date']} không thuộc tuần {$weekNumber} ({$existingJournal->start_date} - {$existingJournal->end_date})");
                }

                $this->studentRepository->createLearningJournalClass([
                    'learning_journal_id' => $existingJournal->learning_journal_id,
                    'date' => $inClass['date'],
                    'my_lesson' => $inClass['my_lesson'],
                    'self_assessment' => $inClass['self_assessment'],
                    'difficulties' => $inClass['my_difficulties'],
                    'plan' => $inClass['my_plan'],
                    'isSolved' => $inClass['problem_solved'],
                ]);
            }
        }

        // -------- XỬ LÝ SELF-STUDY JOURNALS --------
        if (!empty($data['self_study']) && is_array($data['self_study'])) {
            foreach ($data['self_study'] as $selfStudy) {
                $skillsModule = $selfStudy['skills_module'];
                $studentSubject = $subjectMap[$skillsModule] ?? null;

                if (!$studentSubject) {
                    throw new \Exception('Không tìm thấy student_subject cho môn học: ' . $skillsModule);
                }

                $existingJournal = $learningJournals->first(function ($journal) use ($studentSubject, $weekNumber) {
                    return $journal->student_subject_id == $studentSubject->id && $journal->week_number == $weekNumber;
                });

                if (!$existingJournal) {
                    $existingJournal = $this->studentRepository->createLearningJournal([
                        'student_subject_id' => $studentSubject->id,
                        'semester' => $lastSemester,
                        'week_number' => $weekNumber,
                        'start_date' => $defaultStartDate,
                        'end_date' => $defaultEndDate,
                    ]);
                    $learningJournals->push($existingJournal);
                }

                // Kiểm tra ngày học hợp lệ trong khoảng start_date - end_date
                $studyDate = Carbon::parse($selfStudy['date']);
                if ($studyDate->lt(Carbon::parse($existingJournal->start_date)) || $studyDate->gt(Carbon::parse($existingJournal->end_date))) {
                    throw new \Exception("Ngày học {$selfStudy['date']} không thuộc tuần {$weekNumber} ({$existingJournal->start_date} - {$existingJournal->end_date})");
                }

                $this->studentRepository->createLearningJournalSelf([
                    'learning_journal_id' => $existingJournal->learning_journal_id,
                    'date' => $selfStudy['date'],
                    'my_lesson' => $selfStudy['my_lesson'],
                    'time_allocation' => $selfStudy['time_allocation'],
                    'learning_resources' => $selfStudy['learning_resources'],
                    'learning_activities' => $selfStudy['learning_activities'],
                    'isConcentration' => $selfStudy['concentration'],
                    'isFollowPlan' => $selfStudy['plan_follow'],
                    'evaluation' => $selfStudy['evaluation'],
                    'reinforcing' => $selfStudy['reinforcing'],
                    'note' => $selfStudy['notes'],
                ]);
            }
        }
    }

    public function getWeekDates(int $studentId, int $weekNumber): array
    {
         return $this->calculateWeekStartAndEndDate($studentId, $weekNumber);
    }

    public function getAllSubjects()
    {
        return $this->studentRepository->getAllSubjects();
    }

    public function getTodayGoals(Student $student)
    {
        return $this->studentRepository->getTodayGoals($student);
    }

    public function getStudyPlans(int $studentId)
    {
        return $this->studentRepository->getStudyPlansByStudent($studentId);
    }

    public function createStudyPlan(array $data)
    {
        return $this->studentRepository->createStudyPlan($data);
    }

    public function deleteStudyPlan(int $id)
    {
        return $this->studentRepository->deleteStudyPlanById($id);
    }

    public function getSubjectsAndComments($studentId, $weekNumber)
    {
        return $this->studentRepository->fetchSubjectsAndTags($studentId, $weekNumber);
    }

    public function storeTag($data)
    {
        return $this->studentRepository->createTag($data);
    }

    public function getTagsByLearningJournalAndWeek($learningJournalId, $weekNumber)
    {
        return $this->studentRepository->fetchTagsByLearningJournalAndWeek($learningJournalId, $weekNumber);
    }
}
