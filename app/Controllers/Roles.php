<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Role;
use CodeIgniter\HTTP\ResponseInterface;

class Roles extends BaseController
{
    protected $roleModel;
    
    public function __construct()
    {
        $this->roleModel = new Role();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data['roles'] = $this->roleModel->findAll();
        return view('/pages/role/index', $data);
    }

    public function create()
    {
        return view('/pages/role/create');
    }

    public function store()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();

        $validation->setRules([
            'role_name'     => 'required|string',
        ]);

        if(!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->roleModel->insert([
            'role_name' => $data['role_name'],
        ]);

        return redirect()->to('/roles')->with('success', 'Role berhasil bertambah');
    }

    public function edit($id)
    {
        $data['unit'] = $this->roleModel->find($id);
        return view('/pages/role/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();

        $validation->setRules([
            'role_name'     => 'required|string',
        ]);

        if(!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->roleModel->update($id, [
            'role_name' => $data['role_name'],
        ]);

        return redirect()->to('/roles')->with('success', 'Role berhasil berubah');
    }

    public function delete($id)
    {
        $this->roleModel->where('id', $id)->delete();
        return redirect()->to('/roles')->with('success', 'Role berhasil dihapus!');
    }
}
