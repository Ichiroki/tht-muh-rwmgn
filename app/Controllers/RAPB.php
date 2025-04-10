<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RAPB as RAPBModel;

class RAPB extends BaseController
{
    public function index()
    {
        $rapbModel = new RAPBModel();
        $data['rapb'] = $rapbModel->findAll();
        return view('pages/rapb/index.php', $data);
    }
}
