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
}