<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Cashflow;

class ChartController extends BaseController
{

    protected $cashflowModel;

    public function __construct() {
        $this->cashflowModel = new Cashflow();
    }

    public function getChartData()
    {
        $user = session()->get();
        $unitId = $user['unit_id'];

        $cashflowData = $this->cashflowModel
        ->select('category, SUM(amount) as total')
        ->where('unit_id', $unitId)
        ->groupBy('category')
        ->findAll();

        return $this->response->setJSON($cashflowData);
    }

    public function getChartByMonth() {
        $user = session()->get();
        $unitId = $user['unit_id'];

        $cashflowData = $this->cashflowModel
        ->select("DATE_FORMAT(date, '%Y-%m') as bulan, category, SUM(amount) as total")
        ->where('unit_id', $unitId)
        ->groupBy('bulan, category')
        ->orderBy('bulan')
        ->findAll();

        return $this->response->setJSON($cashflowData);
    }

    // Controller yang berfungsi klw yg akses admin aja
    public function getChartByUnit() {
        $data = $this->cashflowModel
        ->select("units.unit_name as unit_name, SUM(amount) as total")
        ->join('units', 'units.id = cashflows.unit_id')
        ->groupBy('units.unit_name')
        ->findAll();

        return $this->response->setJSON($data);
    }
}
