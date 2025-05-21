<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LearningJournalService;

class LearningJournalController extends Controller
{
    protected $service;

    public function __construct(LearningJournalService $service)
    {
        $this->service = $service;
    }

    public function getLearningJournalByStudent(Request $request, $studentId)
    {
        $user = auth()->guard('teacher')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $weekNumber = $request->query('week_number');
        $Classjournals = $this->service->getClassLearningJournalsByStudentAndTeacher($studentId, 4, $weekNumber);
        $Selfjournals = $this->service->getSelfLearningJournalsByStudentAndTeacher($studentId, $user->teacher_id, $weekNumber);

        return response()->json([
            'class_journals' => $Classjournals,
            'self_journals' => $Selfjournals,
        ]);
    }
    public function getTagByLearningJournalId($learningJournalId)
    {
        $tag = $this->service->getTagByLearningJournalId($learningJournalId);
        return response()->json($tag);
    }
}
