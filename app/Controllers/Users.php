<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Unit;
use App\Models\Role;
use CodeIgniter\HTTP\ResponseInterface;

class Users extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new User();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data['users'] = $this->userModel->getAllUserWithRoleAndUnit();
        return view('/pages/user/index', $data);
    }

    public function create()
    {
        $roles = new Role();
        $units = new Unit();
        $data['roles'] = $roles->findAll();
        $data['units'] = $units->findAll();

        return view('/pages/user/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();

        $validation->setRules([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|is_unique[users.email]',
            'password'  => 'required|string',
            'unit_id' => 'required|'
        ]);

        if(!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->userModel->insert([
            'id' => service('uuid')->uuid4()->toString(),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_ARGON2ID),
            'unit_id' => (int) $data['unit_id'],
        ]);

        return redirect()->to('/users')->with('success', 'user berhasil bertambah');
    }

    public function edit($id)
    {
        $roles = new Role();
        $units = new Unit();
        $data['roles'] = $roles->findAll();
        $data['units'] = $units->findAll();
        
        $data['user'] = $this->userModel->getUserWithRole($id);
        return view('/pages/user/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();

        $validation->setRules([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|is_unique[users.email]',
            'password'  => 'required|string',
            'role' => 'required',
            'unit_id' => 'required'
        ]);

        if(!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->userModel->update($id, [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_ARGON2ID),
            'role' => $data['role'],
            'unit_id' => (int) $data['unit_id'],
        ]);

        return redirect()->to('/users')->with('success', 'user berhasil berubah');
    }

    public function delete($id)
    {
        $this->userModel->where('id', $id)->delete();
        return redirect()->to('/users')->with('success', 'user berhasil dihapus!');
    }
}
