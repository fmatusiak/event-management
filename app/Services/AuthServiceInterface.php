<?php

namespace App\Services;

interface AuthServiceInterface
{
    public function login(string $login, string $password, bool $remember = false): void;

    public function logout(): void;
}
