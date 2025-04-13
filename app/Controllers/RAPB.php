<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RAPB as RAPBModel;
use App\Models\Unit;

class RAPB extends BaseController
{
    public function index()
    {
        $rapbModel = new RAPBModel();
        $user = session()->get();

        if($user['role'] === 'admin') {
            $data['rapb'] = $rapbModel->select('rapb_master.*, units.unit_name as unit')->join('units', 'units.id = rapb_master.unit_id')->findAll();
            $data['isAdmin'] = true;
        } else {
            $data['rapb'] = $rapbModel->where('unit_id', $user['unit_id'])->findAll();
            $data['isAdmin'] = false;
        }
        return view('pages/rapb/index.php', $data);
    }

    public function create()
    {
        $unitModel = new Unit();
        $data['units'] = $unitModel->select('id, unit_name')->findAll();
        return view('pages/rapb/create.php', $data);
    }

    public function store() 
    {
        $rapbModel = new RAPBModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'activity_name' => 'required',
            'unit_id' => 'required',
            'category' => 'required|in_list[pengeluaran,pemasukan]',
            'amount' => 'required',
            'year' => 'required|numeric',
            'description' => 'required'
        ]);

        if(!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $uuid = service('uuid');
        $uuid4 = $uuid->uuid4();
        $uuids = $uuid4->toString();

        $amount = str_replace(['Rp', '.'], '', $this->request->getPost('amount'));

        $rapbModel->insert([
            'id' => $uuids,
            'activity_name' => $this->request->getPost('activity_name'),
            'unit_id' => $this->request->getPost('unit_id'),
            'category' => $this->request->getPost('category'),
            'amount' => $amount,
            'year' => $this->request->getPost('year'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/rapb')->with('success', 'Data RAPB berhasil disimpan!');
    }

    public function edit($id) {
        $rapbModel = new RAPBModel();
        $data['rapb'] = $rapbModel->select('rapb_master.*, units.id as unit_id, units.unit_name')->where('rapb_master.id', $id)->join('units', 'units.id = rapb_master.unit_id')->first();

        $unitModel = new Unit();
        $data['units'] = $unitModel->select('id, unit_name')->findAll();

        $data['categories'] = ['pengeluaran', 'pemasukan'];

        if(!$data['rapb']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data RAPB dengan id $id tidak ditemukan.");
        }

        return view('pages/rapb/edit', $data);
    }

    public function update($id) {
        $rapbModel = new RAPBModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'activity_name' => 'required',
            'unit_id' => 'required',
            'category' => 'required|in_list[pengeluaran,pemasukan]',
            'amount' => 'required',
            'year' => 'required|numeric',
            'description' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $amount = str_replace(['Rp', '.'], '', $this->request->getPost('amount'));

        $rapbModel->update($id, [
            'activity_name' => $this->request->getPost('activity_name'),
            'unit_id' => $this->request->getPost('unit_id'),
            'category' => $this->request->getPost('category'),
            'amount' => $amount,
            'year' => $this->request->getPost('year'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/rapb')->with('success', 'Data berhasil diperbarui');
    }

    public function delete($id) {
        $rapbModel = new RAPBModel();
        $rapbModel->delete(['id' => $id]);

        return redirect()->to('/rapb');
    }
}
