<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Units extends BaseController
{
    protected $unitModel;

    public function __construct()
    {
        $this->unitModel = new Unit();
        helper(['form']);
    }

    // GET /api/units
    public function index()
    {
        $units = $this->unitModel->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $units
        ]);
    }

    // POST /api/units
    public function store()
    {
        $data = $this->request->getJSON(true); // Ambil data dalam bentuk array

        $validation = \Config\Services::validation();
        $validation->setRules([
            'unit_name' => 'required|string',
            'address' => 'required|string',
        ]);

        if (!$validation->run($data)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $this->unitModel->insert([
            'unit_name' => $data['unit_name'],
            'address' => $data['address']
        ]);

        return $this->response->setStatusCode(201)->setJSON([
            'status' => 'success',
            'message' => 'Unit berhasil ditambahkan'
        ]);
    }

    // GET /api/units/{id}
    public function show($id)
    {
        $unit = $this->unitModel->find($id);

        if (!$unit) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Unit tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $unit
        ]);
    }

    // PUT /api/units/{id}
    public function update($id)
    {
        $data = $this->request->getJSON(true);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'unit_name' => 'required|string',
            'address' => 'required|string',
        ]);

        if (!$validation->run($data)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $this->unitModel->update($id, [
            'unit_name' => $data['unit_name'],
            'address' => $data['address']
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Unit berhasil diperbarui'
        ]);
    }

    // DELETE /api/units/{id}
    public function delete($id)
    {
        $unit = $this->unitModel->find($id);

        if (!$unit) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Unit tidak ditemukan'
            ]);
        }

        $this->unitModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Unit berhasil dihapus'
        ]);
    }
}
