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
    
    public function getAllClasses(){
        return $this->adminRepository->getAllClasses();
    }

    public function createClass(array $data)
    {
        return $this->adminRepository->createClass($data);
    }
}
