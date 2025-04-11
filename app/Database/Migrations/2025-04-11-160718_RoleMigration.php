<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RoleMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 100
            ],
            'role_name' => [
                'type' => 'CHAR',
                'constraint' => '25'
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('roles');
    }

    public function down()
    {
        $this->forge->dropTable('roles');
    }
}
