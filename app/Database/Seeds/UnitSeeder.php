<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['unit_name' => 'SMK Muhammadiyah 1 Jakarta', 'address' => 'Jl. Garuda No.33 9, RT.9/RW.4, Gn. Sahari Sel., Kec. Kemayoran, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10610 Provinsi: Daerah Khusus Ibukota Jakarta'],
            ['unit_name' => 'SMK Muhammadiyah 2 Jakarta', 'address' => '5, Jl. K.H. Mas Mansyur No.65, RT.5/RW.9, Kb. Melati, Kecamatan Tanah Abang, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10230'],
            ['unit_name' => 'SMK Muhammadiyah 3 Jakarta', 'address' => 'Jl. Gelong Baru Selatan No.23A, RT.12/RW.3, Tomang, Kec. Grogol petamburan, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11440']
        ];

        $this->db->table('units')->insertBatch($data);
    }
}
