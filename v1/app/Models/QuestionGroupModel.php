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

    function getQuestionsByGroup($gr1, $gr2)
    {
        $dt = $this
            ->where('gr_group', $gr1)
            ->where('gr_group_sub', $gr2)
            ->findAll();
       return $dt;
    }
}
