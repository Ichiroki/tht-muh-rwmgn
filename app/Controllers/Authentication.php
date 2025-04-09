<?php

namespace App\Controllers;

class Authentication extends BaseController
{
    public function login(): string
    {
        return view('auth/login');
    }

    public function register(): string
    {
        return view('auth/register');
    }

    public function loginSystem()
    {
        
    }

    public function registerSystem()
    {

    }
}
