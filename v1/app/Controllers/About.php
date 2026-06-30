<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class About extends Controller
{
    public function index(): string
    {
        $data['title'] = 'Sobre - CAPAGIIC';

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('about/index') .
            view('templates/footer', $data);
    }
}
