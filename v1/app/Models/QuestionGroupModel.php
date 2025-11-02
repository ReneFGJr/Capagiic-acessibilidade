<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionGroupModel extends Model
{
    protected $table            = 'question_group';
    protected $primaryKey       = 'id_gr';
    protected $useAutoIncrement = true;

    // ✅ Campos permitidos para inserção/atualização
    protected $allowedFields    = [
        'gr_name',
        'gr_class',
        'gr_group',
        'gr_header',
        'gr_group_sub',
        'created_at',
    ];

    // ✅ Tipo de retorno (objeto ou array)
    protected $returnType       = 'array';

    // ✅ Controle automático de timestamps
    protected $useTimestamps = false; // já existe created_at automático via MySQL

    // ✅ Regras de validação (opcional)
    protected $validationRules = [
        'gr_name'  => 'required|min_length[2]|max_length[100]',
        'gr_class' => 'required|min_length[1]|max_length[10]',
        'gr_group' => 'required|integer',
    ];

    protected $validationMessages = [
        'gr_name' => [
            'required' => 'O nome do grupo é obrigatório.',
        ],
        'gr_class' => [
            'required' => 'A classe do grupo é obrigatória.',
        ],
    ];

    // ✅ Ordenação padrão
    protected $orderBy = ['gr_group' => 'ASC', 'gr_name' => 'ASC'];

    function updateAll()
    {
        $this->db->query("
            UPDATE question_group
            SET
                gr_group = SUBSTRING(gr_class, 1, 2),
                gr_group_sub = SUBSTRING(gr_class, 4, 2),
                gr_header = CASE
                    WHEN gr_class LIKE '%00.0' THEN 1
                    ELSE 0
                END ;
        ");
    }

    function getEtapasForm($gr1 = 0, $gr2 = 0)
    {
        $this->updateAll();
        $dt = $this
            ->where('gr_group', $gr1)
            ->where('gr_header', 1)
            ->where('gr_group_sub > ', 0)
            ->orderBy('gr_group, gr_group_sub', 'ASC')
            ->findAll();
        return $dt;
    }

    function getPrompts()
    {
        $Image = new \App\Models\BancoImagensModel();
        $this->updateAll();
        $dt = $this
            ->where('gr_header', 1)
            ->where('gr_group_sub', 0)
            ->orderBy('gr_class', 'ASC')
            ->findAll();
        foreach ($dt as $key => $form) {
            $dt[$key]['themas'] = $this->select('gr_name')->where('gr_group', $form['gr_group'])
                ->where('gr_header', 0)
                ->findAll();
        }
        return $dt;
    }

    function getForms()
    {
        $Image = new \App\Models\BancoImagensModel();
        $this->updateAll();
        $dt = $this
            ->where('gr_header', 1)
            ->where('gr_group_sub', 0)
            ->orderBy('gr_class', 'ASC')
            ->findAll();
        foreach ($dt as $key => $form) {
            $dt[$key]['image'] = $Image->getImage($form['gr_class']);
        }
        return $dt;
    }

    function getQuestionsByGroup($gr1, $gr2)
    {
        $dt = $this
            ->where('gr_group', $gr1)
            ->where('gr_group_sub', $gr2)
            ->where('gr_header', 0)
            ->findAll();
        return $dt;
    }
}
