<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Authentication extends BaseController
{
    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new User();
        $user = $model->where('email', $email)->first();

        if (!$user) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Email tidak ditemukan'
            ]);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Password salah'
            ]);
        }

        $session = session();
        $session->set([
            'user_id' => $user['id'],
            'user_email' => $user['email'],
            'role' => $user['role'],
            'unit_id' => $user['unit_id'],
            'logged_in' => true
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Login berhasil',
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role'],
                'unit_id' => $user['unit_id']
            ]
        ]);
    }

    public function register()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'first_name' => 'required|string|max_length[30]|min_length[3]',
            'last_name' => 'required|string|max_length[30]|min_length[3]',
            'email' => 'required|string|valid_email|min_length[3]|is_unique[users.email]',
            'password' => 'required|string|min_length[8]|max_length[255]',
            'confirm_password' => 'required|string|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $uuid = service('uuid');
        $id = $uuid->uuid4()->toString();

        $userModel = new User();
        $userModel->insert([
            'id' => $id,
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_ARGON2ID),
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Register berhasil. Silakan login.'
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Logout berhasil.'
        ]);
    }
}
