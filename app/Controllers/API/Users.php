<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
        helper(['form']);
    }

    // GET /api/users
    public function index()
    {
        $users = $this->userModel->getAllUserWithRoleAndUnit();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $users
        ]);
    }

    // POST /api/users
    public function store()
    {
        $data = $this->request->getJSON(true); // Ambil sebagai array

        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|string',
            'unit_id' => 'required',
            'role' => 'required'
        ]);

        if (!$validation->run($data)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $id = service('uuid')->uuid4()->toString();

        $this->userModel->insert([
            'id' => $id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_ARGON2ID),
            'unit_id' => (int)$data['unit_id'],
            'role' => $data['role']
        ]);

        return $this->response->setStatusCode(201)->setJSON([
            'status' => 'success',
            'message' => 'User berhasil ditambahkan'
        ]);
    }

    // GET /api/users/{id}
    public function show($id)
    {
        $user = $this->userModel->getUserWithRole($id);

        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'User tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $user
        ]);
    }

    // PUT /api/users/{id}
    public function update($id)
    {
        $data = $this->request->getJSON(true); // Ambil sebagai array

        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'password' => 'permit_empty|string',
            'role' => 'required',
            'unit_id' => 'required'
        ]);

        if (!$validation->run($data)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $updateData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'unit_id' => (int)$data['unit_id']
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = password_hash($data['password'], PASSWORD_ARGON2ID);
        }

        $this->userModel->update($id, $updateData);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'User berhasil diperbarui'
        ]);
    }

    // DELETE /api/users/{id}
    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'User tidak ditemukan'
            ]);
        }

        $this->userModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'User berhasil dihapus'
        ]);
    }
}
