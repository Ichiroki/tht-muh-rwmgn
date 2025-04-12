<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RapbUserMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'CHAR',
                'constraint' => 36,
            ],
            'rapb_id' => [
                'type' => 'CHAR',
                'constraint' => 36,
            ],
        ]);

        $this->forge->addKey('id');
        $this->forge->addForeignKey('rapb_id', 'rapb_master', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rapb_to_user');
    }

    public function down()
    {
        $this->forge->dropTable('rapb_to_user');
    }
}
