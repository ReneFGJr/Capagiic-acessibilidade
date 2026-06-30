<?php

namespace App\Controllers;

use App\Models\BancoImagensModel;
use CodeIgniter\Controller;

class Images extends Controller
{
    public function index(): string
    {
        $model = new BancoImagensModel();

        $activeGroup = trim((string) $this->request->getGet('group'));

        $groupsRows = $model
            ->select('img_group, COUNT(*) AS total')
            ->groupBy('img_group')
            ->orderBy('img_group', 'ASC')
            ->findAll();

        $groups = [];
        foreach ($groupsRows as $row) {
            $groups[] = [
                'name' => (string) $row['img_group'],
                'total' => (int) $row['total'],
            ];
        }

        if ($activeGroup === '' && !empty($groups)) {
            $activeGroup = $groups[0]['name'];
        }

        $images = [];
        if ($activeGroup !== '') {
            $images = $model
                ->where('img_group', $activeGroup)
                ->orderBy('id_img', 'ASC')
                ->findAll();
        }

        $data = [
            'title' => 'Banco de Imagens - CAPAGIIC',
            'groups' => $groups,
            'activeGroup' => $activeGroup,
            'images' => $images,
        ];

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('images/index', $data) .
            view('templates/footer', $data);
    }
}
