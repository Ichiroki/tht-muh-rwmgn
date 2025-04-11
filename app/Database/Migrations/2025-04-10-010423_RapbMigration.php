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
            'activity_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15.2'
            ],
            'year' => [
                'type' => 'INT',
            ],
            'description' => [
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
