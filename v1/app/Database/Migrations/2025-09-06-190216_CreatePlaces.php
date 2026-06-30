<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePlaces extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pl'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pl_user'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'pl_status'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'pl_name'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'pl_address'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'pl_city'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'pl_state'     => ['type' => 'VARCHAR', 'constraint' => 2],
            'pl_bairro'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'pl_cep'     => ['type' => 'VARCHAR', 'constraint' => 10],
            'pl_avaliations'     => ['type' => 'INT', 'default' => 0],
            'pl_latitude'     => ['type' => 'VARCHAR', 'constraint' => 20],
            'pl_longitude'     => ['type' => 'VARCHAR', 'constraint' => 20],
            'pl_category'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'pl_subcategory'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'pl_description'     => ['type' => 'TEXT'],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id_pl', true);
        $this->forge->addKey('pl_user');
        $this->forge->addForeignKey('pl_user', 'users', 'id_us', 'SET NULL', 'CASCADE', 'fk_places_user');
        $this->forge->createTable('places', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('places');
    }
}
