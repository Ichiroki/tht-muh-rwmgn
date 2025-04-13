<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'first_name', 'last_name', 'email', 'password'];
    
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getUserWithRole($id = null) 
    {
        return $this->select('users.*, roles.role_name')
        ->join('roles', 'roles.id = users.role')
        ->where('users.id', $id)
        ->first();
    }

    public function getAllUserWithRoleAndUnit() 
    {
        return $this->select('users.*, roles.role_name, units.unit_name', )
        ->join('units', 'units.id = users.unit_id')
        ->join('roles', 'roles.id = users.role')
        ->findAll();
    }
}
