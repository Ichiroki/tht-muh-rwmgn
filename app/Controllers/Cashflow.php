<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Cashflow as CashflowModel;
use App\Models\RAPB;
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

        return view('pages/cashflow/index', $data);
    }

    public function create() 
    {
        return view('pages/cashflow/create');
    }

    public function store()
    {
        $data = $this->request->getPost();

        $uuid = service('uuid');
        $id = $uuid->uuid4()->toString();

        $data['id'] = $id;
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

        $rapbModel = new RAPB();
        $rapb = $rapbModel->find($data['rapb_id']);

        if($data['type'] === 'pengeluaran') {
            $rapb['amount'] < $data['amount'] ? redirect()->back()->with('error', 'jumlah melebihi jumlah anggaran yang tersedia') : $rapb['used_amount'] -= $data['amount'];
        } else if ($data['type'] === 'pemasukkan') {
            $rapb['amount'] += $data['amount'];
        }

        return redirect()->to('/cashflow')->with('success', 'Bukti transaksi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['cashflow'] = $this->cashflowModel->find($id);
        return view('pages/cashflow/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        $data = $this->request->getPost();

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
            'rapb_id'     => $data['rapb_id'],
            'type'        => $data['type'],
            'category'    => $data['category'],
            'amount'      => $data['amount'],
            'information' => $data['information'],
            'date'        => $data['date'],
        ]);

        return redirect()->to('/cashflow')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->cashflowModel->delete($id);
        return redirect()->to('/cashflow')->with('success', 'Transaksi berhasil dihapus!');

        $rapbModel = new \App\Models\RapbModel();
        $rapb = $rapbModel->find($cashflow['rapb_id']);

        if($cashflow['type'] === 'pengeluaran') {
            $rapb['used_amount'] += $cashflow['amount'];
        } else if ($cashflow['type'] === 'pemasukan') {
            $rapb['amount'] -= $cashflow['amount'];
        }

        $rapbModel->save($rapb);
    }
}
