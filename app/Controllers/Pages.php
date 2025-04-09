<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function dashboard() 
    {
        return view('pages/dashboard');
    }
}
