<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use CodeIgniter\Controller;

class Form extends Controller
{
    public function selectForm()
    {
        $data['title'] = 'Seleção de Formulário - Acessibilidade';

        $Group = new \App\Models\QuestionGroupModel();
        $forms = $Group->getForms();

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('form/select_form', ['forms' => $forms]) .
            view('templates/footer', $data);
    }
    public function index($etapa='01', $subetapa = '01')
    {
        $gr1 = round($etapa);
        $gr2 = round($subetapa);

        $placeModel = new PlaceModel();
        $QuestionGroup = new \App\Models\QuestionGroupModel();
        $BancoImagens = new \App\Models\BancoImagensModel();
        $Question = new \App\Models\QuestionGroupModel();

        $anonId = getAnonymousSessionId();

        $placeData = $placeModel->where('pl_anon_id', $anonId)->first();

        /********************************* Grupo de Questões */
        $groupHeader = $Question->where('gr_class', $etapa . '.00.00.0')->first();
        $group = $Question->where('gr_class', $etapa.'.'.$subetapa.'.00.0')->first();

        $data['title'] = 'Cadastro de Local - Acessibilidade';

        /********************************* Imagens do Grupo */
        $image = $BancoImagens->getImage($groupHeader['gr_class']);
        $groupHeader['images'] = $image;

        /********************************* Perguntas do Grupo */
        $etapas = $Question->getEtapasForm($etapa, $subetapa);
        $timeline = view('form/timeline', ['etapa' => $etapas, 'etapaAtual' => (int)$gr2]);

        /********************************* Timeline */
        $questions = $QuestionGroup->getQuestionsByGroup($gr1, $gr2);


        /********************************* Exibe Formulário */

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('form/form_header', ['group' => $groupHeader]) .
            view('form/form', ['questions' => $questions,'timeline' => $timeline,'group' => $group]) .
            view('templates/footer',$data);
        ;
    }
}