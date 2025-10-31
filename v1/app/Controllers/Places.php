<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use CodeIgniter\Controller;

class Places extends Controller
{
    public function index($etapa='1')
    {
        $data['title'] = 'Cadastro de Local - Acessibilidade';
        echo view('templates/header', $data);
        echo view('places/form_1');
        echo view('templates/footer');
    }

    public function save()
    {
        $model = new PlaceModel();
        $etapa =  $this->request->getPost('etapa');

        $data = [
            'pl_name'        => $this->request->getPost('pl_name'),
            'pl_address'     => $this->request->getPost('pl_address'),
            'pl_city'        => $this->request->getPost('pl_city'),
            'pl_bairro'      => $this->request->getPost('pl_bairro'),
            'pl_cep'         => $this->request->getPost('pl_cep'),
            'pl_category'    => $this->request->getPost('pl_category'),
            'pl_subcategory' => $this->request->getPost('pl_subcategory'),
            'pl_description' => $this->request->getPost('pl_description'),
        ];

        $model->save($data);
        return redirect()->to('/places')->with('msg', 'Local salvo com sucesso!');
    }
}
