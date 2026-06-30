<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionPlaceAnswerModel extends Model
{
    protected $table            = 'question_place_answers';
    protected $primaryKey       = 'id_qpa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'id_pl',
        'id_gr',
        'qpa_answer',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
