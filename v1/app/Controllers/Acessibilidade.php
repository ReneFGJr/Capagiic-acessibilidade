<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Acessibilidade extends Controller
{
    public function index(): string
    {
        $db = db_connect();

        $summary = $db->query(
            'SELECT COUNT(*) AS total_answers, COUNT(DISTINCT id_pl) AS total_places, COUNT(DISTINCT id_gr) AS total_questions_answered FROM question_place_answers'
        )->getRowArray() ?? ['total_answers' => 0, 'total_places' => 0, 'total_questions_answered' => 0];

        $totalQuestionsBankRow = $db->query('SELECT COUNT(*) AS total_questions_bank FROM question_group WHERE gr_header = 0')->getRowArray();
        $totalQuestionsBank = (int) ($totalQuestionsBankRow['total_questions_bank'] ?? 0);

        $topGroups = $db->query(
            'SELECT q.id_gr, q.gr_name, COUNT(a.id_qpa) AS total
             FROM question_place_answers a
             JOIN question_group q ON q.id_gr = a.id_gr
             GROUP BY q.id_gr, q.gr_name
             ORDER BY total DESC, q.id_gr ASC
             LIMIT 6'
        )->getResultArray();

        $data['title'] = 'Acessibilidade do site - CAPAGIIC';
        $data['summary'] = $summary;
        $data['totalQuestionsBank'] = $totalQuestionsBank;
        $data['topGroups'] = $topGroups;

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('acessibilidade/index', $data) .
            view('templates/footer', $data);
    }

    public function reportar()
    {
        $nome = trim((string) $this->request->getPost('nome'));
        $email = trim((string) $this->request->getPost('email'));
        $pagina = trim((string) $this->request->getPost('pagina'));
        $barreira = trim((string) $this->request->getPost('barreira'));
        $contato = trim((string) $this->request->getPost('contato'));

        if ($barreira === '') {
            return redirect()->back()->withInput()->with('error', 'Descreva a barreira de acessibilidade encontrada.');
        }

        $user = session()->get('user') ?? [];
        $fallbackNome = is_array($user) ? (string) ($user['name'] ?? '') : '';
        $fallbackEmail = is_array($user) ? (string) ($user['email'] ?? '') : '';

        $report = [
            'nome' => $nome !== '' ? $nome : $fallbackNome,
            'email' => $email !== '' ? $email : $fallbackEmail,
            'pagina' => $pagina !== '' ? $pagina : (string) current_url(),
            'barreira' => $barreira,
            'contato' => $contato,
            'ip' => (string) $this->request->getIPAddress(),
            'user_agent' => (string) $this->request->getUserAgent(),
        ];

        log_message(
            'warning',
            'Relato de barreira de acessibilidade recebido: {report}',
            ['report' => json_encode($report, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)]
        );

        return redirect()->to(base_url('acessibilidade'))->with('msg', 'Seu relato foi registrado com sucesso. A equipe responsável pode usar o contato informado para retorno.');
    }
}