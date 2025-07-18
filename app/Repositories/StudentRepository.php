<?php
namespace App\Repositories;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\StudentSubject;
use App\Models\LearningJournal;
use App\Models\LearningJournalClass;
use App\Models\LearningJournalSelf;
use App\Models\Achievement;
use Illuminate\Support\Facades\DB;
use App\Models\StudyPlan;
use Carbon\Carbon;

class StudentRepository
{
    public function updateInfoText(Student $student, array $data)
    {
        $student->name = $data['name'];
        $student->phone = $data['phone'];
        $student->save();

        return $student;
    }

    public function updateAvatar(Student $student, string $avatarUrl)
    {
        $student->avatar = $avatarUrl;
        $student->save();

        return $student;
    }

    public function updateInfo(Student $student, array $data)
    {
        $student->name = $data['name'];
        $student->email = $data['email'];
        $student->phone = $data['phone'];
        $student->avatar = $data['avatar'];
        $student->save();

        return $student;
    }

    public function changePassword(Student $student, string $hashedPassword)
    {
        $student->password = $hashedPassword;
        $student->save();

        return $student;
    }

    public function createLearningJournal(array $data)
    {
        return LearningJournal::create($data);
    }

    public function createLearningJournalClass(array $data)
    {
        return LearningJournalClass::create($data);
    }

    public function createLearningJournalSelf(array $data)
    {
        return LearningJournalSelf::create($data);
    }

    /**
     * Lưu hàng loạt learning journals và các chi tiết class/self study
     * @param array $classJournals dạng:
     *   [
     *     [
     *       'student_subject_id' => int,
     *       'semester' => int,
     *       'week_number' => int,
     *       'start_date' => date,
     *       'end_date' => date,
     *       'class_data' => [ 'date' => ..., 'my_lesson' => ..., ... ],
     *     ],
     *     ...
     *   ]
     * @param array $selfStudyJournals dạng tương tự, có key 'self_study_data'
     */

    public function getAllSubjects()
    {
        return Subject::all();
    }

    public function getTodayGoals(Student $student)
    {
        $today = Carbon::today();
        
        return StudyPlan::where('student_id', $student->student_id)
            ->whereDate('date', $today)
            ->orderBy('start_time')
            ->get(['plan_id as id', 'title', 'start_time', 'end_time', 'date']);
    }

    public function getStudyPlansByStudent($studentId)
    {
        return StudyPlan::where('student_id', $studentId)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get(['plan_id as id', 'title', 'start_time', 'end_time', 'date', 'color']);
    }

    public function createStudyPlan(array $data)
    {
        return StudyPlan::create($data);
    }

    public function deleteStudyPlanById(int $id)
    {
        return StudyPlan::where('plan_id', $id)->delete();
    }

    /**
     * Lấy danh sách LearningJournal của student theo tuần
     */
    public function getLearningJournals($studentId, $weekNumber)
    {
        return LearningJournal::with(['learningJournalClass', 'learningJournalSelf'])
            ->join('student_subject', 'learning_journal.student_subject_id', '=', 'student_subject.id')
            ->join('subjects', 'student_subject.subject_id', '=', 'subjects.subject_id')
            ->where('student_subject.student_id', $studentId)
            ->where('learning_journal.week_number', $weekNumber)
            ->select('learning_journal.*', 'subjects.name as subject_name')
            ->get();
    }

    public function getStudentSubjects($studentId)
    {
        return StudentSubject::where('student_id', $studentId)
            ->with('subject')
            ->get();
    }

    public function getInClassRecords(array $learningJournalIds)
    {
        return LearningJournalClass::whereIn('learning_journal_id', $learningJournalIds)
            ->get();
    }

    public function getSelfStudyRecords(array $learningJournalIds)
    {
        return LearningJournalSelf::whereIn('learning_journal_id', $learningJournalIds)
            ->get();
    }

    public function saveLearningJournals(array $classJournals, array $selfStudyJournals)
    {
        DB::beginTransaction();
        try {
            $now = Carbon::now();

            $allJournals = array_merge($classJournals, $selfStudyJournals);
            $createdJournals = [];

            foreach ($allJournals as $journal) {
                $key = $journal['student_subject_id'] . '_' . $journal['week_number'];

                if (!isset($createdJournals[$key])) {
                    $learningJournal = LearningJournal::create([
                        'student_subject_id' => $journal['student_subject_id'],
                        'semester' => $journal['semester'],
                        'week_number' => $journal['week_number'],
                        'start_date' => $journal['start_date'],
                        'end_date' => $journal['end_date'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                    $createdJournals[$key] = $learningJournal->id;
                }
            }

            $classInsertData = [];
            foreach ($classJournals as $journal) {
                $key = $journal['student_subject_id'] . '_' . $journal['week_number'];
                $learningJournalId = $createdJournals[$key] ?? null;

                if ($learningJournalId && isset($journal['class_data'])) {
                    $data = $journal['class_data'];

                    $classInsertData[] = [
                        'learning_journal_id' => $learningJournalId,
                        'date' => $data['date'],
                        'my_lesson' => $data['my_lesson'],
                        'self_assessment' => $data['self_assessment'],
                        'difficulties' => $data['difficulties'],
                        'plan' => $data['plan'],
                        'isSolved' => $data['isSolved'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
            if (!empty($classInsertData)) {
                LearningJournalClass::insert($classInsertData);
            }

            $selfStudyInsertData = [];
            foreach ($selfStudyJournals as $journal) {
                $key = $journal['student_subject_id'] . '_' . $journal['week_number'];
                $learningJournalId = $createdJournals[$key] ?? null;

                if ($learningJournalId && isset($journal['self_study_data'])) {
                    $data = $journal['self_study_data'];

                    $selfStudyInsertData[] = [
                        'learning_journal_id' => $learningJournalId,
                        'date' => $data['date'],
                        'my_lesson' => $data['my_lesson'],
                        'time_allocation' => $data['time_allocation'],
                        'learning_resources' => $data['learning_resources'],
                        'learning_activities' => $data['learning_activities'],
                        'isConcentration' => $data['isConcentration'],
                        'isFollowPlan' => $data['isFollowPlan'],
                        'evaluation' => $data['evaluation'],
                        'reinforcing' => $data['reinforcing'],
                        'note' => $data['note'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
            if (!empty($selfStudyInsertData)) {
                LearningJournalSelf::insert($selfStudyInsertData);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // \Log::error('Error saving journals: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getJournalsByWeekAndStudent(int $weekNumber, int $studentId)
    {
        return LearningJournal::where('week_number', $weekNumber)
            ->whereHas('studentSubject', function ($q) use ($studentId) {
                $q->where('student_id', $studentId);
            })->get();
    }

    public function getPreviousJournal(int $studentId, int $weekNumber)
    {
        return LearningJournal::whereHas('studentSubject', function ($q) use ($studentId) {
            $q->where('student_id', $studentId);
        })
        ->where('week_number', '<', $weekNumber)
        ->orderByDesc('week_number')
        ->first();
    }


    /**
     * Lấy danh sách LearningJournal của student theo tuần
     */


    /**
     * Lưu hàng loạt learning journals và các chi tiết class/self study
     * @param array $classJournals dạng:
     *   [
     *     [
     *       'student_subject_id' => int,
     *       'semester' => int,
     *       'week_number' => int,
     *       'start_date' => date,
     *       'end_date' => date,
     *       'class_data' => [ 'date' => ..., 'my_lesson' => ..., ... ],
     *     ],
     *     ...
     *   ]
     * @param array $selfStudyJournals dạng tương tự, có key 'self_study_data'
     */


    public function fetchSubjectsAndTags($studentId, $weekNumber)
    {
        $subjects = Subject::whereHas('studentSubject', function ($q) use ($studentId) {
            $q->where('student_id', $studentId);
        })->with('teachers')->get();

        $studentSubjectIds = StudentSubject::where('student_id', $studentId)
            ->get()
            ->unique('subject_id')
            ->pluck('id');
            
        $learningJournals = LearningJournal::whereIn('student_subject_id', $studentSubjectIds)
            ->where('week_number', $weekNumber)
            ->with(['studentSubject.subject'])
            ->get()
            ->map(function ($journal) {
                return [
                    'learning_journal_id' => $journal->learning_journal_id,
                    'student_subject_id' => $journal->student_subject_id,
                    'subject_id' => optional(optional($journal->studentSubject)->subject)->subject_id,
                    'week_number' => $journal->week_number,
                ];
            });

        $learningJournalIds = $learningJournals->pluck('learning_journal_id');

        $tags = Tag::whereIn('learning_journal_id', $learningJournalIds)
            ->with(['student', 'teachers', 'tagReplies'])
            ->get();

        return [
            'subjects' => $subjects,
            'tags' => $tags,
            'learning_journals' => $learningJournals,
        ];
    }

    public function createTag($data)
    {
        return Tag::create($data);
    }

    public function fetchTagsByLearningJournalAndWeek($learningJournalId, $weekNumber)
    {
        $learningJournal = LearningJournal::find($learningJournalId);
        if (!$learningJournal || $learningJournal->week_number != $weekNumber) {
            return collect(); 
        }

        return Tag::where('learning_journal_id', $learningJournalId)
            ->with(['student', 'teachers'])
            ->get();
    }

    public function uploadAchievement(array $data)
    {
        return Achievement::create($data);
    }

    public function getAchievementByStudentId($studentId)
    {
        return Achievement::where('student_id', $studentId)
            ->orderBy('date_achieved', 'desc')
            ->get();
    }

    public function getLearningJournalIds($studentId, $weekNumber)
    {
        return LearningJournal::join('student_subject', 'learning_journal.student_subject_id', '=', 'student_subject.id')
            ->where('student_subject.student_id', $studentId)
            ->where('learning_journal.week_number', $weekNumber)
            ->pluck('learning_journal.learning_journal_id');
    }

    public function updateCell($studentId, $weekNumber, $type, $date, $field, $value)
    {
        $learningJournalIds = $this->getLearningJournalIds($studentId, $weekNumber);

        if ($learningJournalIds->isEmpty()) {
            throw new \Exception('Không tìm thấy learning_journal nào cho student và tuần này');
        }

        $model = $type === 'in_class' ? new LearningJournalClass() : new LearningJournalSelf();

        $record = $model->whereIn('learning_journal_id', $learningJournalIds)
                        ->whereDate('date', $date)
                        ->first();

        if (!$record) {
            throw new \Exception('Record trong bảng con không tồn tại');
        }

        if (!in_array($field, $record->getFillable())) {
            throw new \Exception('Trường dữ liệu không hợp lệ');
        }

        $record->$field = $value;
        $record->save();

        return $record;
    }
}
