<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_us'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'us_name'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'us_email'    => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'us_password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'us_validate' => ['type' => 'INT', 'default' => 0],
            'us_code' => ['type' => 'VARCHAR', 'constraint' => 6, 'null' => true],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id_us', true);
        $this->forge->createTable('users', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
