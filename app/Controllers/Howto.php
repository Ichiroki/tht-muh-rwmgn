<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Howto extends BaseController
{
    public function index()
    {
        return view('pages/howto/index.php');
    }

    public function whatIsRAPB()
    {
        return view('pages/howto/what-is-rapb.php');
    }

    public function howDoesRAPBWork()
    {
        return view('pages/howto/how-does-rapb-work.php');
    }
}
