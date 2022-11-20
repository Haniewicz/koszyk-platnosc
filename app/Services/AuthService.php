<?php
//This is Service file. You should write your logic in here
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
Use App\Models\Cart;
use Illuminate\Support\Str;

class AuthService
{
    public function login(string $email, string $password): array
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return [
                'status' => true,
                'token' => $token,
                'user' => $user,
            ];
        }
        return [
            'status' => false
        ];
    }

    public function register(string $email, string $password): array
    {
        $user = new User();
        $user->email = $email;
        $user->password = bcrypt($password);

        if($user->save()) {
            return [
                'status' => true,
                'user' => $user,
            ];
        }

        return [
            'status' => false
        ];
    }

    public function logout(): bool
    {
        Auth::user()->tokens()->delete();
        return true;
    }
}

?>
