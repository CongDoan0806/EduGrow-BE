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
     public function getDashboardStats(): array
    {
        return [
            'total_teachers' => $this->adminRepository->countTeachers(),
            'total_students' => $this->adminRepository->countStudents(),
            'total_classes'  => $this->adminRepository->countClassGroups(),
            'students_per_class' => $this->adminRepository->getStudentsPerClass(),
            'top_tagged_teachers' => $this->adminRepository->getTopTaggedTeachers(5),
        ];
    }
}