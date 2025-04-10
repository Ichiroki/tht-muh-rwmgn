<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RapbMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'CHAR',
                'constraint' => 36,
            ],
            'nama_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'anggaran' => [
                'type' => 'DECIMAL',
                'constraint' => '15.2'
            ],
            'tahun' => [
                'type' => 'INT',
            ],
            'deskripsi' => [
                'type' => 'VARCHAR',
                'constraint' => 1000
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('rapb_master');
    }

    public function down()
    {
        $this->forge->dropTable('rapb_master');
    }
}
