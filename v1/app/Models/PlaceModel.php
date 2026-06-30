<?php

namespace App\Models;

use CodeIgniter\Model;

class PlaceModel extends Model
{
    protected $table = 'places';
    protected $primaryKey = 'id_pl';
    protected $allowedFields = [
        'pl_user',
        'pl_status',
        'pl_name',
        'pl_address',
        'pl_city',
        'pl_state',
        'pl_bairro',
        'pl_cep',
        'pl_avaliations',
        'pl_latitude',
        'pl_longitude',
        'pl_category',
        'pl_subcategory',
        'pl_description',
        'pl_anon_id'
    ];

    protected $useTimestamps = true;
}
