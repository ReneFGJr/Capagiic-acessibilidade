<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use App\Models\QuestionPlaceAnswerModel;
use CodeIgniter\Controller;

class Form extends Controller
{
    private function buildNavigation(int $gr1, int $gr2): array
    {
        $Question = new \App\Models\QuestionGroupModel();
        $allSteps = $Question
            ->where('gr_header', 1)
            ->where('gr_group_sub >', 0)
            ->orderBy('gr_group', 'ASC')
            ->orderBy('gr_group_sub', 'ASC')
            ->findAll();

        $currentIndex = null;
        foreach ($allSteps as $index => $step) {
            if ((int) $step['gr_group'] === $gr1 && (int) $step['gr_group_sub'] === $gr2) {
                $currentIndex = $index;
                break;
            }
        }

        if ($currentIndex === null) {
            return [
                'prevUrl' => null,
                'nextUrl' => null,
                'isLast' => true,
            ];
        }

        $prevUrl = null;
        $nextUrl = null;

        if ($currentIndex > 0) {
            $prev = $allSteps[$currentIndex - 1];
            $prevUrl = base_url('form/' . (int) $prev['gr_group'] . '/' . str_pad((string) ((int) $prev['gr_group_sub']), 2, '0', STR_PAD_LEFT));
        }

        if ($currentIndex < count($allSteps) - 1) {
            $next = $allSteps[$currentIndex + 1];

            // Nao muda automaticamente para outro grupo; finaliza no fim do grupo atual.
            if ((int) $next['gr_group'] === $gr1) {
                $nextUrl = base_url('form/' . (int) $next['gr_group'] . '/' . str_pad((string) ((int) $next['gr_group_sub']), 2, '0', STR_PAD_LEFT));
            }
        }

        return [
            'prevUrl' => $prevUrl,
            'nextUrl' => $nextUrl,
            'isLast' => $nextUrl === null,
        ];
    }

    public function selectForm()
    {
        $data['title'] = 'Seleção de Formulário - Acessibilidade';

        $Group = new \App\Models\QuestionGroupModel();
        $forms = $Group->getForms();

        $placeModel = new PlaceModel();
        $answerModel = new QuestionPlaceAnswerModel();

        $anonId = getAnonymousSessionId();
        $userId = (int) (session()->get('user_id') ?? 0);

        $placeData = $placeModel->where('pl_anon_id', $anonId)->first();
        if (!$placeData && $userId > 0) {
            $placeData = $placeModel->where('pl_user', $userId)->orderBy('updated_at', 'DESC')->first();
        }

        $progressByGroup = [];
        foreach ($forms as $form) {
            $grGroup = (int) ($form['gr_group'] ?? 0);

            $totalQuestions = $Group
                ->where('gr_group', $grGroup)
                ->where('gr_header', 0)
                ->countAllResults();

            $answered = 0;
            if (!empty($placeData['id_pl']) && $totalQuestions > 0) {
                $rows = $answerModel
                    ->select('question_place_answers.id_gr')
                    ->join('question_group', 'question_group.id_gr = question_place_answers.id_gr')
                    ->where('question_place_answers.id_pl', (int) $placeData['id_pl'])
                    ->where('question_group.gr_group', $grGroup)
                    ->groupBy('question_place_answers.id_gr')
                    ->findAll();

                $answered = count($rows);
            }

            $progressByGroup[$grGroup] = [
                'answered' => $answered,
                'total' => $totalQuestions,
                'missing' => max(0, $totalQuestions - $answered),
            ];
        }

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('form/select_form', ['forms' => $forms, 'progressByGroup' => $progressByGroup]) .
            view('templates/footer', $data);
    }
    public function index($etapa='01', $subetapa = '01')
    {
        $gr1 = round($etapa);
        $gr2 = round($subetapa);

        $placeModel = new PlaceModel();
        $questionPlaceAnswerModel = new QuestionPlaceAnswerModel();
        $QuestionGroup = new \App\Models\QuestionGroupModel();
        $BancoImagens = new \App\Models\BancoImagensModel();
        $Question = new \App\Models\QuestionGroupModel();
        $Question->updateAll();

        $anonId = getAnonymousSessionId();
        $userId = (int) (session()->get('user_id') ?? 0);

        $placeData = $placeModel->where('pl_anon_id', $anonId)->first();
        if (!$placeData && $userId > 0) {
            $placeData = $placeModel->where('pl_user', $userId)->orderBy('updated_at', 'DESC')->first();
        }

        /********************************* Grupo de Questões */
        $groupHeader = $Question
            ->where('gr_group', $gr1)
            ->where('gr_group_sub', 0)
            ->where('gr_header', 1)
            ->first();

        $group = $Question
            ->where('gr_group', $gr1)
            ->where('gr_group_sub', $gr2)
            ->where('gr_header', 1)
            ->first();

        if (!$group) {
            $group = $Question
                ->where('gr_group', $gr1)
                ->where('gr_group_sub', $gr2)
                ->where('gr_header', 0)
                ->first();
        }

        if (!$groupHeader) {
            $groupHeader = [
                'gr_name' => '—',
                'gr_class' => '',
                'images' => '',
            ];
        }

        if (!$group) {
            $group = [
                'gr_name' => '—',
            ];
        }

        $data['title'] = 'Cadastro de Local - Acessibilidade';

        /********************************* Imagens do Grupo */
        $groupHeader['images'] = '';
        if (!empty($groupHeader['gr_class'])) {
            $image = $BancoImagens->getImage($groupHeader['gr_class']);
            $groupHeader['images'] = $image;
        }

        /********************************* Perguntas do Grupo */
        $etapas = $Question->getEtapasForm($etapa, $subetapa);

        /********************************* Questões da etapa atual */
        $questions = $QuestionGroup->getQuestionsByGroup($gr1, $gr2);

        $answersByQuestion = [];
        if (!empty($placeData['id_pl'])) {
            $rows = $questionPlaceAnswerModel
                ->where('id_pl', (int) $placeData['id_pl'])
                ->findAll();

            foreach ($rows as $row) {
                $answersByQuestion[(int) $row['id_gr']] = (string) $row['qpa_answer'];
            }
        }

        /********************************* Progresso por grupo na timeline */
        $groupProgress = [];
        foreach ($etapas as $step) {
            $stepSub = (int) ($step['gr_group_sub'] ?? 0);
            $stepQuestions = $QuestionGroup->getQuestionsByGroup($gr1, $stepSub);
            $total = count($stepQuestions);
            $answered = 0;

            foreach ($stepQuestions as $q) {
                $idGr = (int) ($q['id_gr'] ?? 0);
                if ($idGr > 0 && !empty($answersByQuestion[$idGr])) {
                    $answered++;
                }
            }

            $groupProgress[$stepSub] = [
                'answered' => $answered,
                'total' => $total,
                'missing' => max(0, $total - $answered),
            ];
        }

        $timeline = view('form/timeline', [
            'etapa' => $etapas,
            'etapaAtual' => (int) $gr2,
            'groupProgress' => $groupProgress,
        ]);


        $navigation = $this->buildNavigation($gr1, $gr2);

        /********************************* Exibe Formulário */

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('form/form_header', ['group' => $groupHeader]) .
            view('form/form', [
                'questions' => $questions,
                'timeline' => $timeline,
                'group' => $group,
                'placeData' => $placeData,
                'answersByQuestion' => $answersByQuestion,
                'navigation' => $navigation,
            ]) .
            view('templates/footer',$data);
        ;
    }

    public function saveAnswerAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Requisicao invalida.',
            ]);
        }

        $idPl = (int) $this->request->getPost('id_pl');
        $idGr = (int) $this->request->getPost('id_gr');
        $answer = trim((string) $this->request->getPost('answer'));

        if ($idPl <= 0 || $idGr <= 0 || $answer === '') {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Dados incompletos para salvar a resposta.',
            ]);
        }

        $allowedAnswers = ['Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica'];
        if (!in_array($answer, $allowedAnswers, true)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Resposta invalida.',
            ]);
        }

        $placeModel = new PlaceModel();
        $place = $placeModel->find($idPl);

        if (!$place) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Local nao encontrado.',
            ]);
        }

        $questionModel = new \App\Models\QuestionGroupModel();
        $question = $questionModel->find($idGr);
        if (!$question) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Questao nao encontrada.',
            ]);
        }

        $model = new QuestionPlaceAnswerModel();
        $existing = $model->where('id_pl', $idPl)->where('id_gr', $idGr)->first();

        if ($existing) {
            $model->update($existing['id_qpa'], ['qpa_answer' => $answer]);
        } else {
            $model->insert([
                'id_pl' => $idPl,
                'id_gr' => $idGr,
                'qpa_answer' => $answer,
            ]);
        }

        return $this->response->setJSON([
            'status' => 'ok',
            'message' => 'Resposta salva com sucesso.',
        ]);
    }
}