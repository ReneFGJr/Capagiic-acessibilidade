<?php

namespace App\Controllers;

use App\Models\PlaceModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        if ((bool) (session()->get('isLoggedIn') ?? false)) {
            return redirect()->to('/');
        }

        $data['title'] = 'Entrar - CAPAGIIC';

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('auth/login') .
            view('templates/footer', $data);
    }

    public function attemptLogin()
    {
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        if ($email === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Informe email e senha.');
        }

        $model = new UserModel();
        $user = $model->where('us_email', $email)->first();

        if (!$user || !password_verify($password, (string) $user['us_password'])) {
            return redirect()->back()->withInput()->with('error', 'Credenciais inválidas.');
        }

        session()->set([
            'isLoggedIn' => true,
            'user_id' => $user['id_us'],
            'name' => $user['us_name'],
            'email' => $user['us_email'],
            'user' => [
                'id' => $user['id_us'],
                'name' => $user['us_name'],
                'email' => $user['us_email'],
            ],
        ]);

        return redirect()->to('/')->with('msg', 'Login realizado com sucesso.');
    }

    public function register()
    {
        $data['title'] = 'Cadastrar-se - CAPAGIIC';

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('auth/register') .
            view('templates/footer', $data);
    }

    public function attemptRegister()
    {
        $name = trim((string) $this->request->getPost('name'));
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');
        $passwordConfirm = (string) $this->request->getPost('password_confirm');

        if ($name === '' || $email === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Preencha todos os campos obrigatórios.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('error', 'Email inválido.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->withInput()->with('error', 'A senha deve ter no mínimo 6 caracteres.');
        }

        if ($password !== $passwordConfirm) {
            return redirect()->back()->withInput()->with('error', 'As senhas não conferem.');
        }

        $model = new UserModel();
        $exists = $model->where('us_email', $email)->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Já existe usuário com este email.');
        }

        $model->insert([
            'us_name' => $name,
            'us_email' => $email,
            'us_password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/login')->with('msg', 'Cadastro realizado. Faça login para continuar.');
    }

    public function forgotPassword()
    {
        $data['title'] = 'Recuperar senha - CAPAGIIC';

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('auth/forgot_password') .
            view('templates/footer', $data);
    }

    public function attemptForgotPassword()
    {
        $email = trim((string) $this->request->getPost('email'));
        $newPassword = (string) $this->request->getPost('new_password');
        $newPasswordConfirm = (string) $this->request->getPost('new_password_confirm');

        if ($email === '' || $newPassword === '' || $newPasswordConfirm === '') {
            return redirect()->back()->withInput()->with('error', 'Preencha todos os campos.');
        }

        if ($newPassword !== $newPasswordConfirm) {
            return redirect()->back()->withInput()->with('error', 'As novas senhas não conferem.');
        }

        if (strlen($newPassword) < 6) {
            return redirect()->back()->withInput()->with('error', 'A nova senha deve ter no mínimo 6 caracteres.');
        }

        $model = new UserModel();
        $user = $model->where('us_email', $email)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email não encontrado.');
        }

        $model->update($user['id_us'], [
            'us_password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/login')->with('msg', 'Senha atualizada com sucesso.');
    }

    public function profile()
    {
        if (!(bool) (session()->get('isLoggedIn') ?? false)) {
            return redirect()->to('/login')->with('error', 'Faça login para acessar seu perfil.');
        }

        $userId = (int) (session()->get('user_id') ?? 0);
        $placeModel = new PlaceModel();
        $places = $placeModel
            ->where('pl_user', $userId)
            ->orderBy('updated_at', 'DESC')
            ->findAll();

        $data['title'] = 'Meu Perfil - CAPAGIIC';
        $data['places'] = $places;

        return
            view('templates/header', $data) .
            view('templates/navbar', $data) .
            view('auth/profile', $data) .
            view('templates/footer', $data);
    }

    public function logout()
    {
        session()->remove(['isLoggedIn', 'user_id', 'name', 'email', 'user']);

        return redirect()->to('/')->with('msg', 'Você saiu da sua conta.');
    }
}
