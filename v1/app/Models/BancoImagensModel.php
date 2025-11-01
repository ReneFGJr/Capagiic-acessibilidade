<?php

namespace App\Models;

use CodeIgniter\Model;

class BancoImagensModel extends Model
{
    protected $table = 'banco_imagens';
    protected $primaryKey = 'id_img';
    protected $allowedFields = ['img_name', 'img_descricao', 'img_url'];
    protected $returnType = 'array';

    function getImage($img_id)
    {
        $dt = $this->where('id_img', $img_id)->first();
        if ($dt == null) {
            return '';
        }
        $RSP = '<img src="' . base_url($dt['img_url']) . '" title="' . esc($dt['img_descricao']) . '" class="img-fluid"/>';
        return $RSP;
    }
}
