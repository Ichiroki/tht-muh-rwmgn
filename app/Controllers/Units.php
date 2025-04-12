<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Unit;

class Units extends BaseController
{
    protected $unitModel;
    
    public function __construct()
    {
        $this->unitModel = new Unit();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data['units'] = $this->unitModel->findAll();
        return view('/pages/units/index', $data);
    }

    public function create()
    {
        return view('/pages/units/create');
    }

    public function store()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();

        $validation->setRules([
            'unit_name'     => 'required|string',
            'address'        => 'required|string',
        ]);

        if(!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->unitModel->insert([
            'unit_name' => $data['unit_name'],
            'address' => $data['address']
        ]);

        return redirect()->to('/units')->with('success', 'Unit berhasil bertambah');
    }

    public function edit($id)
    {
        $data['unit'] = $this->unitModel->find($id);
        return view('/pages/units/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();

        $validation->setRules([
            'unit_name'     => 'required|string',
            'address'        => 'required|string',
        ]);

        if(!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->unitModel->update($id, [
            'unit_name' => $data['unit_name'],
            'address' => $data['address']
        ]);

        return redirect()->to('/units')->with('success', 'Unit berhasil berubah');
    }

    public function delete($id)
    {
        $this->unitModel->where('id', $id)->delete();
        return redirect()->to('/units')->with('success', 'Unit berhasil dihapus!');
    }
}
