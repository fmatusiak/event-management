<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): RedirectResponse
    {
        try {
            $login = $request->input('login');
            $password = $request->input('password');
            $remember = $request->input('remember', false);

            $this->authService->login($login, $password, $remember);

            return redirect()->intended('/events');
        } catch (ValidationException) {
            return redirect()->back()->withInput($request->only('login'))->withErrors([
                'login' => __('auth.failed')
            ]);
        }
    }

    public function logout(): RedirectResponse
    {
        $this->authService->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('view.login');
    }
}
