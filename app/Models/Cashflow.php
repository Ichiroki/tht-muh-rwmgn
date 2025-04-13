<?php

namespace App\Models;

use CodeIgniter\Model;

class Cashflow extends Model
{
    protected $table            = 'cashflows';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'unit_id', 'rapb_id', 'type', 'category', 'amount', 'information', 'date'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getCashflowWithUnitAndRAPB($unitId = null) {
        $builder = $this->select('cashflows.*, units.unit_name, rapb_master.activity_name')
        ->join('units', 'units.id = cashflows.unit_id')
        ->join('rapb_master', 'rapb_master.id = cashflows.rapb_id');
        
        if($unitId !== null) {
            return $builder->findAll();
        }
        return $builder->where('cashflows.unit_id', $unitId);
    }
}
