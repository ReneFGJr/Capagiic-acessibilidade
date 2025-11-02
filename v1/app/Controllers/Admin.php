<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    public function prompt()
    {
        $data['title'] = 'Admin Prompt - Gerador';

        $Group = new \App\Models\QuestionGroupModel();
        $data['prompt'] = $Group->getPrompts();

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('admin/prompt',$data) .
            view('templates/footer', $data);
    }
}