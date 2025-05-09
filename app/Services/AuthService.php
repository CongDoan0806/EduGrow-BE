<?php
namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(array $credentials)
    {
        $result = $this->authRepository->findUserByEmail($credentials['email']);

        if (!$result || !$this->authRepository->validatePassword($result['user'], $credentials['password'])) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $token = $result['user']->createToken($result['role'] . '-token')->plainTextToken;

        return [
            'user' => $result['user'],
            'role' => $result['role'],
            'token' => $token,
        ];
    }
}
