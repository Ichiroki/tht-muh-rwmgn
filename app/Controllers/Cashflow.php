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
            $data['isAdmin'] = true;
        } else {
            $data['cashflows'] = $this->cashflowModel->getCashflowWithUnitAndRAPB($unitId);
            $data['isAdmin'] = false;
        }

        return view('pages/cashflow/index', $data);
    }

    public function create() 
    {
        $user = session()->get();
        $user_unit_id = $user['unit_id'];

        $unitModel = new Unit();
        $rapbModel = new Rapb();

        if($user['role'] === 'admin') {
            $data['rapbs'] = $rapbModel->findAll();
        } else {
            $data['rapbs'] = $rapbModel->where('unit_id', $user_unit_id)->findAll();
        }
        $data['units'] = $unitModel->findAll();

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
    
        if ($data['category'] === 'pengeluaran') {
            $newUsedAmount = $usedAmount + $amount;
        
            if ($newUsedAmount > $rapbAmount) {
                return redirect()->back()->withInput()->with('error', 'Jumlah melebihi anggaran tersedia.');
            }
        
            $exactAmount = $rapbAmount - $newUsedAmount;
        
            $rapbModel->update($data['rapb_id'], [
                'used_amount' => $newUsedAmount,
                'exact_amount' => $exactAmount,
            ]);
        }
    
        // Cek pemasukan
        if ($data['category'] === 'pemasukan') {
            $newUsedAmount = $usedAmount - $amount;
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
        $units = new Unit();
        $rapbs = new RAPB();

        $user = session()->get();

        $data['cashflow'] = $this->cashflowModel->find($id);
        $data['units'] = $units->findAll();
        $data['rapbs'] = $rapbs->findAll();
        return view('pages/cashflow/edit', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();
        $data = $this->request->getPost();

        $amountRaw = $this->request->getPost('amount');
        $amountBaru = (int) preg_replace('/[^0-9]/', '', $amountRaw);

        $validation->setRules([
            'unit_id'     => 'required',
            'rapb_id'     => 'required',
            'category'    => 'required|in_list[pemasukan,pengeluaran]',
            'amount'      => 'required',
            'information' => 'permit_empty|string',
            'date'        => 'required|valid_date'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $cashflowLama = $this->cashflowModel->find($id);
        if (!$cashflowLama) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $rapbModel = new \App\Models\RAPB();
        $rapb = $rapbModel->find($data['rapb_id']);

        if (!$rapb) {
            return redirect()->back()->with('error', 'RAPB tidak ditemukan.');
        }

        $amountLama   = (int) $cashflowLama['amount'];
        $usedAmount   = (int) $rapb['used_amount'];
        $exactAmount  = (int) $rapb['exact_amount'];

        $kategoriLama = $cashflowLama['category'];
        $kategoriBaru = $data['category'];

        if ($kategoriLama === 'pengeluaran') {
            $usedAmount -= $amountLama;
            $exactAmount += $amountLama;
        } else {
            $usedAmount += $amountLama;
            $exactAmount -= $amountLama;
        }

        if ($kategoriBaru === 'pengeluaran') {
            $usedAmount += $amountBaru;

            // Validasi batas
            if ($usedAmount > $rapb['amount']) {
                return redirect()->back()->withInput()->with('error', 'Jumlah melebihi anggaran tersedia.');
            }

            $exactAmount -= $amountBaru;
        } else {
            $usedAmount -= $amountBaru;
            $exactAmount += $amountBaru;
        }

        $rapbModel->update($data['rapb_id'], [
            'used_amount'   => $usedAmount,
            'exact_amount'  => $exactAmount
        ]);

        $this->cashflowModel->update($id, [
            'unit_id'     => $data['unit_id'],
            'rapb_id'     => $data['rapb_id'],
            'category'    => $kategoriBaru,
            'amount'      => $amountBaru,
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
    
        if (!$cashflow || !$rapb) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
    
        $usedAmount = (int) $rapb['used_amount'];
        $exactAmount = (int) $rapb['exact_amount'];
        $amount = (int) $cashflow['amount'];
    
        if ($cashflow['category'] === 'pengeluaran') {
            $usedAmount -= $amount;
            $exactAmount += $amount;
        } elseif ($cashflow['category'] === 'pemasukan') {
            $usedAmount += $amount;
            $exactAmount -= $amount;
        }
    
        $rapbModel->update($cashflow['rapb_id'], [
            'used_amount' => $usedAmount,
            'exact_amount' => $exactAmount,
        ]);
    
        $this->cashflowModel->delete($id);
    
        return redirect()->to('/cashflow')->with('success', 'Transaksi berhasil dihapus!');
    }
    
    
}
