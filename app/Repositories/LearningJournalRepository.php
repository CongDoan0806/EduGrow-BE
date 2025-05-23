<?php

namespace App\Repositories;

use App\Models\LearningJournal;
use App\Models\LearningJournalClass;
use App\Models\LearningJournalSelf;
use App\Models\StudentSubject;
use App\Models\Subject;
use App\Models\TagReplies;
use Illuminate\Support\Facades\DB;

class LearningJournalRepository
{
    protected $model;

    public function __construct(LearningJournal $learningJournal)
    {
        $this->model = $learningJournal;
    }

    
     public function getClassLearningJournalsByStudentAndTeacher($teacherId, $studentId, $weekNumber)
    {
        return LearningJournalClass::select(
                'subjects.name as subject_name',
                'learning_journal.learning_journal_id',
                'learning_journal.created_at as journal_created_at',
                'learning_journal.start_date',
                'learning_journal.end_date',
                'learning_journal_class.my_lesson',
                'learning_journal_class.self_assessment',
                'learning_journal_class.difficulties',
                'learning_journal_class.plan',
                'learning_journal_class.isSolved',
                'learning_journal.week_number',
                'learning_journal_class.created_at'
            )
            ->join('learning_journal', 'learning_journal.learning_journal_id', '=', 'learning_journal_class.learning_journal_id')
            ->join('student_subject', 'student_subject.id', '=', 'learning_journal.id')
            ->join('subjects', 'subjects.subject_id', '=', 'student_subject.subject_id')
            ->where('subjects.teacher_id', $teacherId)
            ->where('student_subject.student_id', $studentId)
            ->where('learning_journal.week_number', $weekNumber)
            ->orderBy('learning_journal_class.created_at', 'desc')
            ->get();
    }

        public function getCurrentWeekNumber($studentId)
    {
        $studentSubjectIds = StudentSubject::where('student_id', $studentId)->pluck('id');

        return LearningJournal::whereIn('id', $studentSubjectIds)
            ->orderBy('week_number', 'desc')
            ->value('week_number');
    }

    public function getSelfLearningJournalsByStudentAndTeacher($teacherId, $studentId, $weekNumber)
{
    return LearningJournalSelf::select(
            'subjects.name as subject_name',
            'learning_journal.learning_journal_id',
            'learning_journal_self.my_lesson',
            'learning_journal_self.time_allocation',
            'learning_journal_self.learning_resources',
            'learning_journal_self.learning_activities',
            'learning_journal_self.isConcentration',
            'learning_journal_self.isFollowPlan',
            'learning_journal_self.evaluation',
            'learning_journal_self.reinforcing',
            'learning_journal_self.note',
            'learning_journal_self.created_at'
        )
        ->join('learning_journal', 'learning_journal.learning_journal_id', '=', 'learning_journal_self.learning_journal_id')
        ->join('student_subject', 'student_subject.id', '=', 'learning_journal.id')
        ->join('subjects', 'subjects.subject_id', '=', 'student_subject.subject_id')
        ->where('subjects.teacher_id', $teacherId)
        ->where('student_subject.student_id', $studentId)
        ->where('learning_journal.week_number', $weekNumber)
        ->orderBy('learning_journal_self.created_at', 'desc')
        ->get();
}

 public function getTagByLearningJournalId($id)
{
    return DB::table('tags')
        ->select(
            'tags.tag_id',
            'students.name as student_name',
            'students.avatar as student_avatar',
            'tag_replies.reply_id',
            'tags.message',
            'teachers.name as teacher_name',
            'teachers.image as teacher_image',
            'tags.created_at as tag_created_at',
            'tag_replies.content',
            'tag_replies.created_at as reply_created_at'
        )
        ->leftJoin('tag_replies', 'tag_replies.tag_id', '=', 'tags.tag_id')
        ->join('learning_journal', 'learning_journal.learning_journal_id', '=', 'tags.learning_journal_id')
        ->join('student_subject', 'student_subject.id', '=', 'learning_journal.id')
        ->join('students', 'students.student_id', '=', 'student_subject.student_id')
        ->join('subjects', 'subjects.subject_id', '=', 'student_subject.subject_id')
        ->join('teachers', 'teachers.teacher_id', '=', 'subjects.teacher_id')
        ->where('learning_journal.learning_journal_id', $id)
        ->get();
}

    public function getAllLearningJournals()
    {
        return $this->model->all();
    }

    public function getLearningJournalById($id)
    {
        return $this->model->find($id);
    }

    public function createLearningJournal(array $data)
    {
        return $this->model->create($data);
    }

    public function updateLearningJournal($id, array $data)
    {
        $learningJournal = $this->getLearningJournalById($id);
        if ($learningJournal) {
            $learningJournal->update($data);
            return $learningJournal;
        }
        return null;
    }

    public function deleteLearningJournal($id)
    {
        $learningJournal = $this->getLearningJournalById($id);
        if ($learningJournal) {
            return $learningJournal->delete();
        }
        return false;
    }

}