<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $uuid = service('uuid')->uuid4()->toString();

        $data = [
            [
                'id' => $uuid,
                'first_name' => 'Ichiroki',
                'last_name' => 'Kagetsu',
                'email' => 'ichiroki@gmail.com',
                'password' => password_hash("password", PASSWORD_ARGON2ID),
                'unit_id' => 1,
                'role' => 1
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
