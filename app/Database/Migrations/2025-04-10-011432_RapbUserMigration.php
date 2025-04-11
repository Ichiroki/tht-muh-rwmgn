<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RapbUserMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'rapb_id' => [
                'type' => 'CHAR',
                'constraint' => 36,
                'null' => false
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 10,
                'null' => false
            ]
        ]);

        $this->forge->addForeignKey('rapb_id', 'rapb_master', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rapb_to_user');
    }

    public function down()
    {
        $this->forge->dropTable('rapb_to_user');
    }
}
