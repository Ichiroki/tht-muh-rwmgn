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

    public function create()
    {
        return view('pages/rapb/create.php');
    }

    public function store() 
    {
        $rapbModel = new RAPBModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_kegiatan' => 'required',
            'kategori' => 'required',
            'anggaran' => 'required',
            'tahun' => 'required|numeric',
            'deskripsi' => 'required'
        ]);

        if(!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $uuid = service('uuid');
        $uuid4 = $uuid->uuid4();
        $uuids = $uuid4->toString();

        $anggaran = str_replace(['Rp', '.'], '', $this->request->getPost('anggaran'));

        $rapbModel->insert([
            'id' => $uuids,
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'kategori' => $this->request->getPost('kategori'),
            'anggaran' => $anggaran,
            'tahun' => $this->request->getPost('tahun'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/rapb')->with('success', 'Data RAPB berhasil disimpan!');
    }

    public function edit($id) {
        $rapbModel = new RAPBModel();
        $data['rapb'] = $rapbModel->find($id);

        if(!$data['rapb']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data RAPB dengan id $id tidak ditemukan.");
        }

        return view('pages/rapb/edit', $data);
    }

    public function update($id) {
        $rapbModel = new RAPBModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_kegiatan' => 'required',
            'kategori' => 'required',
            'anggaran' => 'required',
            'tahun' => 'required|numeric',
            'deskripsi' => 'required'
        ]);

        if(!$validation->withRequest($this->request)->run()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data RAPB dengan id $id tidak ditemukan.");
        }

        $anggaran = str_replace(['Rp', '.'], '', $this->request->getPost('anggaran'));

        $rapbModel->update($id, [
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'kategori' => $this->request->getPost('kategori'),
            'anggaran' => $anggaran,
            'tahun' => $this->request->getPost('tahun'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/rapb')->with('success', 'Data berhasil diperbarui');
    }
}
