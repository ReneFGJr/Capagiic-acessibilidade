<?php

namespace App\Controllers;

use App\Models\BancoImagensModel;
use App\Models\QuestionGroupModel;
use CodeIgniter\Controller;

class Images extends Controller
{
    private function getUploadGroups(): array
    {
        $groupModel = new QuestionGroupModel();

        return $groupModel
            ->select('id_gr, gr_class, gr_name')
            ->where('gr_header', 1)
            ->where('gr_group_sub', 0)
            ->orderBy('gr_class', 'ASC')
            ->findAll();
    }

    private function ensureProtectedDirectory(string $directory): void
    {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $indexFile = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'index.html';
        if (!is_file($indexFile)) {
            file_put_contents($indexFile, '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><meta name="robots" content="noindex,nofollow"><title>Access denied</title></head><body></body></html>');
        }

        $htaccessFile = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '.htaccess';
        if (!is_file($htaccessFile)) {
            file_put_contents($htaccessFile, "Options -Indexes\n<IfModule authz_core_module>\n    <FilesMatch \\\.(php|phtml|php[0-9]?)$>\n        Require all denied\n    </FilesMatch>\n</IfModule>\n<IfModule !authz_core_module>\n    <FilesMatch \\\.(php|phtml|php[0-9]?)$>\n        Deny from all\n    </FilesMatch>\n</IfModule>\n");
        }
    }

    public function index(): string
    {
        $model = new BancoImagensModel();
        $session = session();
        $isLoggedIn = (bool) ($session->get('isLoggedIn') ?? false);

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
            'isLoggedIn' => $isLoggedIn,
        ];

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('images/index', $data) .
            view('templates/footer', $data);
    }

    public function upload()
    {
        if (!(bool) (session()->get('isLoggedIn') ?? false)) {
            return redirect()->to('/login')->with('error', 'Faça login para enviar imagens.');
        }

        $data = [
            'title' => 'Enviar imagem - CAPAGIIC',
            'groups' => $this->getUploadGroups(),
        ];

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('images/upload', $data) .
            view('templates/footer', $data);
    }

    public function storeUpload()
    {
        if (!(bool) (session()->get('isLoggedIn') ?? false)) {
            return redirect()->to('/login')->with('error', 'Faça login para enviar imagens.');
        }

        $rules = [
            'group_id' => 'required|integer',
            'img_name' => 'required|min_length[2]|max_length[100]',
            'img_descricao' => 'permit_empty|max_length[1000]',
            'image_file' => 'uploaded[image_file]|is_image[image_file]|mime_in[image_file,image/jpg,image/jpeg,image/png,image/gif,image/webp]|max_size[image_file,4096]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $groupId = (int) $this->request->getPost('group_id');
        $groupModel = new QuestionGroupModel();
        $group = $groupModel->find($groupId);

        if (!$group) {
            return redirect()->back()->withInput()->with('error', 'Grupo inválido.');
        }

        $groupClass = trim((string) ($group['gr_class'] ?? ''));
        $groupName = trim((string) ($group['gr_name'] ?? ''));

        if ($groupClass === '' || $groupName === '') {
            return redirect()->back()->withInput()->with('error', 'Não foi possível identificar o grupo selecionado.');
        }

        $basePath = ROOTPATH . 'public/assets/img';
        $groupDirectory = $basePath . DIRECTORY_SEPARATOR . $groupClass;
        $this->ensureProtectedDirectory($basePath);
        $this->ensureProtectedDirectory($groupDirectory);

        $uploadedFile = $this->request->getFile('image_file');
        if (!$uploadedFile || !$uploadedFile->isValid()) {
            return redirect()->back()->withInput()->with('error', 'Arquivo de imagem inválido.');
        }

        $newFileName = $uploadedFile->getRandomName();
        $uploadedFile->move($groupDirectory, $newFileName);

        $relativePath = 'assets/img/' . $groupClass . '/' . $newFileName;
        $model = new BancoImagensModel();
        $model->insert([
            'img_ID' => $groupClass,
            'img_group' => $groupName,
            'img_name' => trim((string) $this->request->getPost('img_name')),
            'img_descricao' => trim((string) $this->request->getPost('img_descricao')) ?: $groupName,
            'img_url' => $relativePath,
        ]);

        return redirect()->to('/images?group=' . urlencode($groupName))->with('msg', 'Imagem enviada com sucesso.');
    }
}
