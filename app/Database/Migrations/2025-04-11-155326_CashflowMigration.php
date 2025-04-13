<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CashflowMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'CHAR',
                'constraint' => 36,
            ],
            'unit_id' => [
                'type' => 'BIGINT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'rapb_id' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'null' => true
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15.2'
            ],
            'information' => [
                'type' => 'VARCHAR',
                'constraint' => 1000
            ],
            'date' => [
                'type' => 'DATE',
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rapb_id', 'rapb_master', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('unit_id', 'units', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cashflows');
    }

    public function down()
    {
        $this->forge->dropTable('cashflows');
    }
}
