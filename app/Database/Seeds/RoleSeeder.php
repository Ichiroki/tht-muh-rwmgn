<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['role_name' => 'Admin'],
            ['role_name' => 'Unit']
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}
