<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use CodeIgniter\Controller;

class Places extends Controller
{
    public function index($etapa = '1')
    {
        $data['title'] = 'Cadastro de Local - Acessibilidade';
        echo view('templates/header', $data);
        switch ($etapa) {
            case '1':
                echo view('places/form_1');
                break;
            case '2':
                echo view('places/form_2');
                break;
            case '3':
                echo view('places/form_3');
                break;
            case '4':
                echo view('places/form_4');
                break;
            default:
                return redirect()->to('/places/1')->with('error', 'Etapa inválida.');
        }
        echo view('templates/footer');
    }

    public function save()
    {
        $model = new PlaceModel();
        $etapa =  $this->request->getPost('etapa');

        $anonId = getAnonymousSessionId();

        switch ($etapa) {
            case '1':
                $this->saveStep1($model, $anonId);
                break;
            case '2':
                // Implement step 2 saving logic
                break;
            case '3':
                // Implement step 3 saving logic
                break;
            case '4':
                // Implement step 4 saving logic
                break;
            default:
                return redirect()->to('/places/2')->with('error', 'Etapa inválida.');
        }

        return redirect()->to('/places/' . ($etapa + 1))->with('msg', 'Local salvo com sucesso!');
    }

    function saveStep1($model, $anonId)
    {
        $dt = $model->where('pl_anon_id', $anonId)->first();
        if ($dt) {
            // Atualiza o registro existente
            $data = [
                'pl_name' => $this->request->getPost('nome_local'),
            ];
            $model->update($dt['id_pl'], $data);
            return;
        } else {
            $data = [
                'pl_name' => $this->request->getPost('nome_local'),
                'pl_anon_id' => $anonId,
            ];
            $model->save($data);
            return;
        }
    }

    function saveStep2($model, $anonId)
    {
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
        // Implement step 2 saving logic
    }
}
