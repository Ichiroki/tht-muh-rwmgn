<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected function initialize()
    {
        $this->allowedFields[] = '';
    }
}