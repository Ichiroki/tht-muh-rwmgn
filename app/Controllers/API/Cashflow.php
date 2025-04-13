<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
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

        if ($role === 'admin') {
            $cashflows = $this->cashflowModel->getCashflowWithUnitAndRAPB();
        } else {
            $cashflows = $this->cashflowModel->getCashflowWithUnitAndRAPB($unitId);
        }

        return $this->respond(['status' => 'success', 'data' => $cashflows]);
    }

    public function show($id = null)
    {
        $cashflow = $this->cashflowModel->find($id);
        if (!$cashflow) {
            return $this->failNotFound('Data tidak ditemukan');
        }
        return $this->respond(['status' => 'success', 'data' => $cashflow]);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
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

        if (!$validation->run($data)) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $user = session()->get();
        $amount = (int) str_replace(['Rp', '.'], '', $data['amount']);

        $rapbModel = new Rapb();
        $rapb = $rapbModel->find($data['rapb_id']);

        if (!$rapb) {
            return $this->failNotFound('RAPB tidak ditemukan');
        }

        $usedAmount = (int) $rapb['used_amount'];
        $rapbAmount = (int) $rapb['amount'];

        if ($data['category'] === 'pengeluaran') {
            if ($rapbAmount < $amount) {
                return $this->fail('Jumlah melebihi anggaran tersedia.');
            }

            $newUsedAmount = $usedAmount + $amount;
            $exactAmount = $rapbAmount - $newUsedAmount;

            $rapbModel->update($data['rapb_id'], [
                'used_amount' => $newUsedAmount,
                'exact_amount' => $exactAmount,
            ]);
        } else {
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

        return $this->respondCreated(['status' => 'success', 'message' => 'Transaksi berhasil ditambahkan']);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'unit_id' => 'required',
            'rapb_id' => 'required',
            'category' => 'required|in_list[pemasukan,pengeluaran]',
            'amount' => 'required|numeric',
            'information' => 'permit_empty|string',
            'date' => 'required|valid_date',
        ]);

        if (!$validation->run($data)) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $this->cashflowModel->update($id, $data);

        return $this->respond(['status' => 'success', 'message' => 'Transaksi berhasil diperbarui']);
    }

    public function delete($id = null)
    {
        $cashflow = $this->cashflowModel->find($id);
        if (!$cashflow) {
            return $this->failNotFound('Transaksi tidak ditemukan');
        }

        $rapbModel = new Rapb();
        $rapb = $rapbModel->find($cashflow['rapb_id']);

        if (!$rapb) {
            return $this->failNotFound('RAPB tidak ditemukan');
        }

        if ($cashflow['category'] === 'pengeluaran') {
            $rapb['used_amount'] += $cashflow['amount'];
            $rapb['exact_amount'] = $rapb['amount'] + $rapb['used_amount'];
        } elseif ($cashflow['category'] === 'pemasukan') {
            $rapb['amount'] -= $cashflow['amount'];
            $rapb['exact_amount'] = $rapb['amount'] - $rapb['used_amount'];
        }

        $rapbModel->save($rapb);
        $this->cashflowModel->delete($id);

        return $this->respondDeleted(['status' => 'success', 'message' => 'Transaksi berhasil dihapus']);
    }
}
