<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Reports extends Controller
{
    public function index(): string
    {
        $data['title'] = 'Relatorios e Indicadores - Acessibilidade';

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('reports/index') .
            view('templates/footer', $data);
    }
}
