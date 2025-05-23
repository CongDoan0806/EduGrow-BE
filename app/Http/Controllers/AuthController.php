<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Models\Student;
use App\Models\Teacher;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

public function login(Request $request)
{
    $data = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $result = $this->authService->login($data);

    // Cập nhật thời gian updated_at theo role
    if ($result['role'] === 'student') {
        Student::where('email', $data['email'])->update(['updated_at' => now()]);
    } elseif ($result['role'] === 'teacher') {
        Teacher::where('email', $data['email'])->update(['updated_at' => now()]);
    }

    return response()->json([
        'user' => $result['user'],
        'role' => $result['role'],
        'token' => $result['token'],
    ]);
}
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
