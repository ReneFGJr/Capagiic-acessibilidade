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
        $img = $this->getImageUrl($img_id);
        $RSP = '<img src="' . base_url($img['image']) . '" title="' . esc($img['description']) . '" class="img-fluid"/>';
        return $RSP;
    }

    function getImageUrl($img_id)
    {
        $dt = $this
            ->where('id_img', $img_id)
            ->Orwhere('img_name', $img_id)
            ->first();
        if ($dt == null) {
            $img = 'assets/img/no-image.png';
            $desc = 'Imagem não encontrada';
        } else {
            $img = $dt['img_url'];
            $desc = $dt['img_descricao'];
        }
        return ['image' => $img, 'description' => $desc];
    }
}
