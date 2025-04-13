<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Roles extends BaseController
{
    protected $roleModel;

    public function __construct()
    {
        $this->roleModel = new Role();
        helper(['form']);
    }

    // GET /api/roles
    public function index()
    {
        $roles = $this->roleModel->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $roles
        ]);
    }

    // POST /api/roles
    public function store()
    {
        $data = $this->request->getJSON(true);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'role_name' => 'required|string',
        ]);

        if (!$validation->run($data)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $this->roleModel->insert([
            'role_name' => $data['role_name']
        ]);

        return $this->response->setStatusCode(201)->setJSON([
            'status' => 'success',
            'message' => 'Role berhasil ditambahkan'
        ]);
    }

    // GET /api/roles/{id}
    public function show($id)
    {
        $role = $this->roleModel->find($id);

        if (!$role) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Role tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $role
        ]);
    }

    // PUT /api/roles/{id}
    public function update($id)
    {
        $data = $this->request->getJSON(true);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'role_name' => 'required|string',
        ]);

        if (!$validation->run($data)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $this->roleModel->update($id, [
            'role_name' => $data['role_name']
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Role berhasil diperbarui'
        ]);
    }

    // DELETE /api/roles/{id}
    public function delete($id)
    {
        $role = $this->roleModel->find($id);

        if (!$role) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Role tidak ditemukan'
            ]);
        }

        $this->roleModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Role berhasil dihapus'
        ]);
    }
}
