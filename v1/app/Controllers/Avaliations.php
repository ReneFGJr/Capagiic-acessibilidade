<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use CodeIgniter\Controller;

class Avaliations extends Controller
{
    public function index(): string
    {
        $data['title'] = 'Avaliacoes - CAPAGIIC';

        $userId = (int) (session()->get('user_id') ?? 0);
        $places = [];

        if ($userId > 0) {
            $placeModel = new PlaceModel();
            $places = $placeModel
                ->where('pl_user', $userId)
                ->orderBy('updated_at', 'DESC')
                ->findAll();
        }

        $data['places'] = $places;
        $data['isLoggedIn'] = $userId > 0;

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('avaliations/index', $data) .
            view('templates/footer', $data);
    }
}
