<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPlUserToPlaces extends Migration
{
    private function hasPlUserColumn(): bool
    {
        $result = $this->db->query("SHOW COLUMNS FROM `places` LIKE 'pl_user'")->getResultArray();
        return !empty($result);
    }

    public function up()
    {
        if (!$this->hasPlUserColumn()) {
            $this->forge->addColumn('places', [
                'pl_user' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'id_pl',
                ],
            ]);

            $this->db->query('ALTER TABLE `users` ENGINE=InnoDB');
            $this->db->query('ALTER TABLE `places` ENGINE=InnoDB');
            $this->db->query('ALTER TABLE `places` ADD INDEX `idx_places_pl_user` (`pl_user`)');
            $this->db->query('ALTER TABLE `places` ADD CONSTRAINT `fk_places_user` FOREIGN KEY (`pl_user`) REFERENCES `users`(`id_us`) ON UPDATE CASCADE ON DELETE SET NULL');
        }
    }

    public function down()
    {
        if ($this->hasPlUserColumn()) {
            $this->db->query('ALTER TABLE `places` DROP FOREIGN KEY `fk_places_user`');
            $this->db->query('ALTER TABLE `places` DROP INDEX `idx_places_pl_user`');
            $this->forge->dropColumn('places', 'pl_user');
        }
    }
}
