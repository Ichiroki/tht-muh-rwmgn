<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RAPB extends BaseController
{
    protected $rapbModel;

    public function __construct()
    {
        $this->rapbModel = new RAPBModel();
        helper(['form']);
    }

    // GET /api/rapb
    public function index()
    {
        $user = session()->get();

        if ($user['role'] === 'admin') {
            $rapb = $this->rapbModel
                ->select('rapb_master.*, units.unit_name as unit')
                ->join('units', 'units.id = rapb_master.unit_id')
                ->findAll();
        } else {
            $rapb = $this->rapbModel
                ->where('unit_id', $user['unit_id'])
                ->findAll();
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $rapb
        ]);
    }

    // POST /api/rapb
    public function store()
    {
        $data = $this->request->getJSON(true);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'activity_name' => 'required',
            'unit_id'       => 'required',
            'category'      => 'required|in_list[pengeluaran,pemasukan]',
            'amount'        => 'required',
            'year'          => 'required|numeric',
            'description'   => 'required',
        ]);

        if (!$validation->run($data)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $uuid = service('uuid')->uuid4()->toString();
        $amount = str_replace(['Rp', '.'], '', $data['amount']);

        $this->rapbModel->insert([
            'id'            => $uuid,
            'activity_name' => $data['activity_name'],
            'unit_id'       => $data['unit_id'],
            'category'      => $data['category'],
            'amount'        => $amount,
            'year'          => $data['year'],
            'description'   => $data['description'],
        ]);

        return $this->response->setStatusCode(201)->setJSON([
            'status' => 'success',
            'message' => 'Data RAPB berhasil ditambahkan'
        ]);
    }

    // GET /api/rapb/{id}
    public function show($id)
    {
        $rapb = $this->rapbModel
            ->select('rapb_master.*, units.unit_name as unit')
            ->join('units', 'units.id = rapb_master.unit_id')
            ->find($id);

        if (!$rapb) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data RAPB tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $rapb
        ]);
    }

    // PUT /api/rapb/{id}
    public function update($id)
    {
        $data = $this->request->getJSON(true);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'activity_name' => 'required',
            'unit_id'       => 'required',
            'category'      => 'required|in_list[pengeluaran,pemasukan]',
            'amount'        => 'required',
            'year'          => 'required|numeric',
            'description'   => 'required',
        ]);

        if (!$validation->run($data)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $amount = str_replace(['Rp', '.'], '', $data['amount']);

        $this->rapbModel->update($id, [
            'activity_name' => $data['activity_name'],
            'unit_id'       => $data['unit_id'],
            'category'      => $data['category'],
            'amount'        => $amount,
            'year'          => $data['year'],
            'description'   => $data['description'],
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data RAPB berhasil diperbarui'
        ]);
    }

    // DELETE /api/rapb/{id}
    public function delete($id)
    {
        $rapb = $this->rapbModel->find($id);

        if (!$rapb) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data RAPB tidak ditemukan'
            ]);
        }

        $this->rapbModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data RAPB berhasil dihapus'
        ]);
    }
}
