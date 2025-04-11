<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Cashflow as CashflowModel;
use CodeIgniter\HTTP\ResponseInterface;

class Cashflow extends BaseController
{
    protected $cashflowModel;

    public function __construct()
    {
        $this->cashflowModel = new CashflowModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $user = session()->get();
        $role = $user['role'];
        $unitId = $user['unit_id'];

        if(in_array($role, ['admin', 'pcm'])) {
            $data['cashflow'] = $this->cashflowModel->findAll();
        } else {
            $data['cashflow'] = $this->cashflowModel->where('unit_id', $unitId)->findAll();
        }

        return view('cashflow/index', $data);
    }

    public function create() 
    {
        return view('cashflow/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'rapb_id' => 'required',
            'type' => 'required|in_list[pemasukan, pengeluaran]',
            'category' => 'required',
            'amount' => 'required|numeric',
            'information' => 'permit_empty|string',
            'date' => 'required|valid_date'
        ]);

        if(!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $user = session()->get();
        $uuid = service('uuid');
        $id = $uuid->uuid4()->toString();

        $this->cashflowModel->insert([
            'id' => $id,
            'unit_id' => $user['unit_id'],
            'rapb_id' => $this->request->getPost('rapb_id'),
            'type' => $this->request->getPost('type'),
            'category' => $this->request->getPost('category'),
            'amount' => $this->request->getPost('amount'),
            'information' => $this->request->getPost('information'),
            'date' => $this->request->getPost('date'),
        ]);

        return redirect()->to('/cashflow')->with('success', 'Bukti transaksi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['cashflow'] = $this->cashflowModel->find($id);
        return view('cashflow/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'rapb_id'     => 'required',
            'type'        => 'required|in_list[pemasukan,pengeluaran]',
            'category'    => 'required',
            'amount'      => 'required|numeric',
            'information' => 'permit_empty|string',
            'date'        => 'required|valid_date'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->cashflowModel->update($id, [
            'rapb_id'     => $this->request->getPost('rapb_id'),
            'type'        => $this->request->getPost('type'),
            'category'    => $this->request->getPost('category'),
            'amount'      => $this->request->getPost('amount'),
            'information' => $this->request->getPost('information'),
            'date'        => $this->request->getPost('date'),
        ]);

        return redirect()->to('/cashflow')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->cashflowModel->delete($id);
        return redirect()->to('/cashflow')->with('success', 'Transaksi berhasil dihapus!');
    }
}
