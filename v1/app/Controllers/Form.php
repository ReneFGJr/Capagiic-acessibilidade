<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use CodeIgniter\Controller;

class Form extends Controller
{
    public function index($etapa='01')
    {
        $anonId = getAnonymousSessionId();
        $placeModel = new PlaceModel();
        $placeData = $placeModel->where('pl_anon_id', $anonId)->first();

        /********************************* Grupo de Questões */
        $Question = new \App\Models\QuestionGroupModel();
        $group = $Question->where('gr_class', $etapa.'.00.00.0')->first();

        $data['title'] = 'Cadastro de Local - Acessibilidade';

        /********************************* Imagens do Grupo */
        $BancoImagens = new \App\Models\BancoImagensModel();
        $image = $BancoImagens->getImage($group['gr_class']);
        $group['images'] = $image;

        $group['etapa'] = view('form/timeline', ['etapaAtual' => (int)$etapa]);
        $questions = $Question->getQuestionsByGroup(1,1);

        /********************************* Exibe Formulário */

        return
            view('templates/header', $data) .
            view('form/form_header', ['group' => $group]) .
            view('form/form', ['questions' => $questions]) .
            view('templates/footer',$data);
        ;
    }
}