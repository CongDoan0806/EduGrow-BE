<?php
namespace App\Services;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Repositories\AdminRepository;
class AdminService{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository){
        $this->adminRepository =  $adminRepository;
    }
    public function getAllStudent(){
        return $this->adminRepository->getAll();
    }
    public function getAllTeacher(){
        return $this->adminRepository->getAllTeacher();
    }
    
    public function createUser(array $data)
    {
        return $this->adminRepository->addUser($data);
    }
    public function updateUser($id, $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']); 
        }


    return $this->adminRepository->update($id, $data);
    }
    public function deleteUser($id, $role)
    {
        return $this->adminRepository->deleteUser($id, $role);
    }


    
    public function getAllClasses(){
        return $this->adminRepository->getAllClasses();
    }

    public function createClass(array $data)
    {
        return $this->adminRepository->createClass($data);
    }

    public function getDashboardStats(): array
    {
        return [
            'total_teachers' => $this->adminRepository->countTeachers(),
            'total_students' => $this->adminRepository->countStudents(),
            'active_accounts_daily' => $this->adminRepository->countActiveAccounts('day'),
            'active_accounts_weekly' => $this->adminRepository->countActiveAccounts('week'),
            'active_accounts_monthly' => $this->adminRepository->countActiveAccounts('month'),
            'total_classes' => $this->adminRepository->countClassGroups(),
            'active_classes' => $this->adminRepository->countActiveClasses(),
            'students_per_class' => $this->adminRepository->getStudentsPerClass(),
            'weekly_tag_counts' => $this->adminRepository->getWeeklyTagCounts(),
            'daily_teacher_replies' => $this->adminRepository->getDailyReplyCountsFromTeachers(),
        ];
    }

}

