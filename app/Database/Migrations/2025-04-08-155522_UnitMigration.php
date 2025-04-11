<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UnitMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 10,
            ],
            'unit_name' => [
                'type' => 'VARCHAR',
                'constraint' => 150
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 350
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('units');
    }

    public function down()
    {
        $this->forge->dropTable('units');
    }
}
