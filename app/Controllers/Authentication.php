<?php

namespace App\Controllers;

class Authentication extends BaseController
{
    public function login(): string
    {
        return view('auth/login');
    }
}
