<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuestionPlaceAnswers extends Migration
{
    private function ensureInnoDb(string $tableName): void
    {
        if ($this->db->tableExists($tableName)) {
            $this->db->query("ALTER TABLE `{$tableName}` ENGINE=InnoDB");
        }
    }

    public function up()
    {
        $this->ensureInnoDb('places');
        $this->ensureInnoDb('question_group');

        $this->forge->addField([
            'id_qpa' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_pl' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_gr' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'qpa_answer' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id_qpa', true);
        $this->forge->addUniqueKey(['id_pl', 'id_gr'], 'uq_qpa_place_question');
        $this->forge->addKey('id_pl');
        $this->forge->addKey('id_gr');
        $this->forge->addForeignKey('id_pl', 'places', 'id_pl', 'CASCADE', 'CASCADE', 'fk_qpa_place');
        $this->forge->addForeignKey('id_gr', 'question_group', 'id_gr', 'CASCADE', 'CASCADE', 'fk_qpa_question');
        $this->forge->createTable('question_place_answers', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('question_place_answers', true);
    }
}
