<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use CodeIgniter\Controller;

class Places extends Controller
{
    private function getCurrentPlace(PlaceModel $model, string $anonId): ?array
    {
        $userId = (int) (session()->get('user_id') ?? 0);

        if ($userId > 0) {
            $byUser = $model->where('pl_user', $userId)->orderBy('updated_at', 'DESC')->first();
            if (!empty($byUser)) {
                return $byUser;
            }
        }

        $byAnon = $model->where('pl_anon_id', $anonId)->orderBy('updated_at', 'DESC')->first();
        return $byAnon ?: null;
    }

    public function index($etapa = '1')
    {
        $model = new PlaceModel();
        $anonId = getAnonymousSessionId();
        $placeData = $this->getCurrentPlace($model, $anonId);

        $data['title'] = 'Cadastro de Local - Acessibilidade';
        $data['placeData'] = $placeData;
        $content = '';

        switch ($etapa) {
            case '1':
                $content = view('places/form_1', $data);
                break;
            case '2':
                $content = view('places/form_2', $data);
                break;
            case '3':
                $content = view('places/form_3', $data);
                break;
            case '4':
                $content = view('places/form_4', $data);
                break;
            default:
                return redirect()->to('/places/1')->with('error', 'Etapa inválida.');
        }

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            $content .
            view('templates/footer', $data);
    }

    public function save()
    {
        $model = new PlaceModel();
        $etapa =  $this->request->getPost('etapa');

        $anonId = getAnonymousSessionId();

        switch ($etapa) {
            case '1':
                $this->saveStep1($model, $anonId);
                return redirect()->to('/places/2')->with('msg', 'Local salvo com sucesso!');
            case '2':
                $this->saveStep2($model, $anonId);
                return redirect()->to('/places/4')->with('msg', 'Endereco salvo com sucesso!');
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

    public function confirmAndBackProfile()
    {
        $model = new PlaceModel();
        $anonId = getAnonymousSessionId();
        $dt = $this->getCurrentPlace($model, $anonId);

        if ($dt) {
            $model->update($dt['id_pl'], ['pl_status' => 1]);
        }

        return redirect()->to('/perfil')->with('msg', 'Local enviado para avaliacao.');
    }

    function saveStep1($model, $anonId)
    {
        $userId = (int) (session()->get('user_id') ?? 0);
        $dt = $this->getCurrentPlace($model, $anonId);

        if ($dt) {
            // Atualiza o registro existente
            $data = [
                'pl_name' => $this->request->getPost('nome_local'),
            ];

            if ($userId > 0) {
                $data['pl_user'] = $userId;
            }

            $model->update($dt['id_pl'], $data);
            return;
        } else {
            $data = [
                'pl_name' => $this->request->getPost('nome_local'),
                'pl_anon_id' => $anonId,
            ];

            if ($userId > 0) {
                $data['pl_user'] = $userId;
            }

            $model->save($data);
            return;
        }
    }

    function saveStep2($model, $anonId)
    {
        $userId = (int) (session()->get('user_id') ?? 0);
        $dt = $this->getCurrentPlace($model, $anonId);

        $cep = preg_replace('/\D/', '', (string) $this->request->getPost('pl_cep'));
        $logradouro = trim((string) $this->request->getPost('pl_logradouro'));
        $numero = trim((string) $this->request->getPost('pl_numero'));
        $complemento = trim((string) $this->request->getPost('pl_complemento'));
        $bairro = trim((string) $this->request->getPost('pl_bairro'));
        $ibge = (int) $this->request->getPost('pl_city');

        $addressParts = array_filter([$logradouro, $numero, $complemento], static fn($value) => $value !== '');
        $address = implode(', ', $addressParts);

        $data = [
            'pl_address' => $address,
            'pl_city' => $ibge,
            'pl_bairro' => $bairro,
            'pl_cep' => $cep,
            'pl_status' => 0,
        ];

        if ($userId > 0) {
            $data['pl_user'] = $userId;
        }

        if ($dt) {
            $model->update($dt['id_pl'], $data);
            return;
        }

        $data['pl_name'] = trim((string) $this->request->getPost('pl_name')) ?: 'Local sem nome';
        $data['pl_anon_id'] = $anonId;
        $model->save($data);
    }
}
