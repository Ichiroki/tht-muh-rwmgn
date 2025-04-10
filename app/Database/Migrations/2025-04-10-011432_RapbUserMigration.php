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
    }

    public function down()
    {
        //
    }
}
