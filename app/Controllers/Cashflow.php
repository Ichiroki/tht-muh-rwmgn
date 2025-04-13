<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Cashflow as CashflowModel;
use App\Models\RAPB;
use App\Models\Unit;
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
        $unitId = (int) $user['unit_id'];

        if($role === 'admin') {
            $data['cashflows'] = $this->cashflowModel->getCashflowWithUnitAndRAPB();
        } else {
            $data['cashflows'] = $this->cashflowModel->getCashflowWithUnitAndRAPB($unitId);
        }

        return view('pages/cashflow/index', $data);
    }

    public function create() 
    {
        $unitModel = new Unit();
        $rapbModel = new Rapb();

        $data['units'] = $unitModel->findAll();
        $data['rapbs'] = $rapbModel->findAll();

        return view('pages/cashflow/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
    
        $uuid = service('uuid');
        $id = $uuid->uuid4()->toString();
    
        $validation = \Config\Services::validation();
        $validation->setRules([
            'unit_id' => 'required',
            'rapb_id' => 'required',
            'category' => 'required|in_list[pemasukan,pengeluaran]',
            'amount' => 'required',
            'information' => 'permit_empty|string',
            'date' => 'required|valid_date',
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    
        $user = session()->get();
        $amount = (int) str_replace(['Rp', '.'], '', $data['amount']);
    
        $rapbModel = new RAPB();
        $rapb = $rapbModel->find($data['rapb_id']);
        $usedAmount = (int) $rapb['used_amount'];
        $rapbAmount = (int) $rapb['amount'];
    
        // Cek pengeluaran
        if ($data['category'] === 'pengeluaran') {
            if ($rapbAmount < $amount) {
                return redirect()->back()->withInput()->with('error', 'Jumlah melebihi anggaran tersedia.');
            }
    
            $newUsedAmount = $usedAmount + $amount;
            $exactAmount = $rapbAmount - $newUsedAmount;
    
            $rapbModel->update($data['rapb_id'], [
                'used_amount' => $newUsedAmount,
                'exact_amount' => $exactAmount,
            ]);
        }
    
        // Cek pemasukan
        if ($data['category'] === 'pemasukan') {
            $newUsedAmount = $usedAmount + $amount;
            $exactAmount = $rapbAmount + $amount;
    
            $rapbModel->update($data['rapb_id'], [
                'used_amount' => $newUsedAmount,
                'exact_amount' => $exactAmount,
            ]);
        }
    
        $this->cashflowModel->insert([
            'id' => $id,
            'unit_id' => $user['unit_id'],
            'rapb_id' => $data['rapb_id'],
            'category' => $data['category'],
            'amount' => $amount,
            'information' => $data['information'],
            'date' => $data['date'],
        ]);
    
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
            'unit_id'     => 'required',
            'rapb_id'     => 'required',
            'category'    => 'required|in_list[pemasukan, pengeluaran]',
            'amount'      => 'required|numeric',
            'information' => 'permit_empty|string',
            'date'        => 'required|valid_date'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->cashflowModel->update($id, [
            'unit_id'     => $data['unit_id'],
            'rapb_id'     => $data['rapb_id'],
            'category'    => $data['category'],
            'amount'      => $data['amount'],
            'information' => $data['information'],
            'date'        => $data['date'],
        ]);

        return redirect()->to('/cashflow')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function delete($id)
    {
        $cashflow = $this->cashflowModel->find($id);
        $rapbModel = new \App\Models\Rapb();
        $rapb = $rapbModel->find($cashflow['rapb_id']);

        if($cashflow['category'] === 'pengeluaran') {
            $rapb['used_amount'] += $cashflow['amount'];
            $rapb['exact_amount'] = $rapb['amount'] + $rapb['used_amount'];
            $rapbModel->save($rapb);
        } else if ($cashflow['category'] === 'pemasukan') {
            $rapb['amount'] -= $cashflow['amount'];
            $rapb['exact_amount'] = $rapb['amount'] - $rapb['used_amount'];
            $rapbModel->save($rapb);
        }

        $this->cashflowModel->delete($id);

        return redirect()->to('/cashflow')->with('success', 'Transaksi berhasil dihapus!');
    }
}
