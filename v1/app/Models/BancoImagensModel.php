<?php

namespace App\Models;

use CodeIgniter\Model;

class BancoImagensModel extends Model
{
    protected $table = 'banco_imagens';
    protected $primaryKey = 'id_img';
    protected $allowedFields = ['img_ID', 'img_group', 'img_name', 'img_descricao', 'img_url'];
    protected $returnType = 'array';

    function getImageUrl($img_id)
    {
        $dt = $this
            ->where('id_img', $img_id)
            ->orWhere('img_ID', $img_id)
            ->first();
        if ($dt == null) {
            $img = 'assets/img/no-image.png';
            $desc = 'Imagem não encontrada';
        } else {
            $img = $dt['img_url'];
            $desc = $dt['img_descricao'];
        }
        return ['image' => base_url($img), 'descricao' => $desc];
    }
    function getImage($img_id) {
        $image = $this->getImageUrl($img_id);
        $image = '<img src="'.$image['image'].'" alt="'.esc($image['descricao']).'" class="img-fluid rounded-2" />';
        return $image;
    }
}
