<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
            $Image = new \App\Models\BancoImagensModel();
            $data['title'] = 'Autoavaliação Acessibilidade';
            $data['image'] = $Image->getImageUrl('home');

            $RSP = view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('welcome_message',$data) .
            view('templates/footer',$data);
        return $RSP;
    }
}
