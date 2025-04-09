<?php

namespace App\Controllers;

use App\Models\User;

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
        $session = session();
        $model = new User();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if($user) {
            if(password_verify($password, $user['password'])) {
                $session->set([
                    'user_id' => $user['id'],
                    'user_email' => $user['email'],
                    'logged_in' => true
                ]);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', 'Password salah');
            }
        } else {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }
    }

    public function registerSystem()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'first_name' => 'required|string|max_length[30]|min_length[3]',
            'last_name' => 'required|string|max_length[30]|min_length[3]',
            'email' => 'required|string|valid_email|min_length[3]|is_unique[users.email]',
            'password' => 'required|string|min_length[8]|max_length[255]',
            'confirm_password' => 'required|string|min_length[3]|max_length[255]|matches[password]'
        ];

        if(!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validators->getErrors());
        }

        $userModel = new User();
        $userModel->save([
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_ARGON2ID),
        ]);

        return redirect()->to('/login')->with('success', 'Register berhasil! Silakan login');
    }
}
