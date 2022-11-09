<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{

    public function __construct(private readonly AuthService $authService)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        return response()->json($this->authService->login($data['email'], $data['password']));
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        return response()->json($this->authService->register($data['email'], $data['password']));
    }

    public function logout(): JsonResponse
    {
        return response()->json($this->authService->logout());
    }
}
