<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthenticatedUserResource;

class AuthController extends Controller
{

    public function __construct(private readonly AuthService $authService)
    {
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json(
            new AuthenticatedUserResource($request->user())
        );
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
