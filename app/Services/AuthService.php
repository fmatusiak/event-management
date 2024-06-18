<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    /**
     * @throws ValidationException
     */
    public function login(string $login, string $password, bool $remember = false): void
    {
        if (!Auth::attempt(['login' => $login, 'password' => $password], $remember)) {
            throw ValidationException::withMessages([
                'login' => [__('messages.auth_failed')],
            ]);
        }
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
