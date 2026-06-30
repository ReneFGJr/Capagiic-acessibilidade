<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPlStatusToPlaces extends Migration
{
    private function hasPlStatusColumn(): bool
    {
        $result = $this->db->query("SHOW COLUMNS FROM `places` LIKE 'pl_status'")->getResultArray();
        return !empty($result);
    }

    public function up()
    {
        if (!$this->hasPlStatusColumn()) {
            $this->forge->addColumn('places', [
                'pl_status' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0,
                    'after'      => 'pl_user',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->hasPlStatusColumn()) {
            $this->forge->dropColumn('places', 'pl_status');
        }
    }
}
