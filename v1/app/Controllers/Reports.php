<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Reports extends Controller
{
    public function index(): string
    {
        $db = db_connect();

        $summary = $db->query(
            'SELECT COUNT(*) AS total_answers, COUNT(DISTINCT id_pl) AS total_places, COUNT(DISTINCT id_gr) AS total_questions_answered FROM question_place_answers'
        )->getRowArray() ?? ['total_answers' => 0, 'total_places' => 0, 'total_questions_answered' => 0];

        $totalBankQuestionsRow = $db->query('SELECT COUNT(*) AS total_questions_bank FROM question_group WHERE gr_header = 0')->getRowArray();
        $totalQuestionsBank = (int) ($totalBankQuestionsRow['total_questions_bank'] ?? 0);

        $answersByType = $db->query(
            'SELECT qpa_answer, COUNT(*) AS total FROM question_place_answers GROUP BY qpa_answer ORDER BY total DESC'
        )->getResultArray();

        $totalAnswers = (int) ($summary['total_answers'] ?? 0);
        foreach ($answersByType as &$row) {
            $rowTotal = (int) ($row['total'] ?? 0);
            $row['percent'] = $totalAnswers > 0 ? round(($rowTotal / $totalAnswers) * 100, 2) : 0;
        }
        unset($row);

        $topGroups = $db->query(
            'SELECT q.id_gr, q.gr_name, COUNT(a.id_qpa) AS total
             FROM question_place_answers a
             JOIN question_group q ON q.id_gr = a.id_gr
             GROUP BY q.id_gr, q.gr_name
             ORDER BY total DESC, q.id_gr ASC
             LIMIT 10'
        )->getResultArray();

        $placePerformance = $db->query(
            'SELECT p.id_pl, p.pl_name, p.pl_status, COUNT(DISTINCT a.id_gr) AS answered_questions
             FROM places p
             LEFT JOIN question_place_answers a ON a.id_pl = p.id_pl
             GROUP BY p.id_pl, p.pl_name, p.pl_status
             ORDER BY answered_questions DESC, p.id_pl ASC'
        )->getResultArray();

        foreach ($placePerformance as &$place) {
            $answered = (int) ($place['answered_questions'] ?? 0);
            $place['completion_percent'] = $totalQuestionsBank > 0 ? round(($answered / $totalQuestionsBank) * 100, 2) : 0;
        }
        unset($place);

        $data['title'] = 'Relatorios e Indicadores - Acessibilidade';
        $data['summary'] = $summary;
        $data['totalQuestionsBank'] = $totalQuestionsBank;
        $data['answersByType'] = $answersByType;
        $data['topGroups'] = $topGroups;
        $data['placePerformance'] = $placePerformance;

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('reports/index', $data) .
            view('templates/footer', $data);
    }
}
