<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

helper('sisdoc');
helper('email');

class Users extends BaseController
{
    public function index($d1='',$d2='',$d3='')
    {
        /* NAO USADO PARA AS APIS */
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Origin', '*');
        header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
        header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

        if ((get("test") == '') and (get("code") == '')) {
            if (($d2 != 'import') and ($d2 != 'in') and ($d2 != 'searchSelect')) {
                #header("Access-Control-Allow-Headers: Content-Type");
                header("Content-Type: application/json");
            }
        }
        $RSP = [];
        switch ($d1) {
            case 'exist':
                $RSP = $this->exist();
                break;
            case 'validate':
                $RSP = $this->validateUser();
                break;
            case 'signup':
                $RSP = $this->create();
                break;
            case 'update':
                return $this->update($d2);
            case 'delete':
                return $this->delete($d2);
            default:
                $RSP['status'] = '500';
                $RSP['error'] = 'Ação inválida';
                $RSP['action'] = $d1;
                $RSP['data'] = array_merge($_POST,$_GET);;
        }
        return $this->response->setJSON($RSP);
    }

    function exist()
    {
        $RSP = [];
        $model = new UserModel();
        $email = get('email');
        $dt = $model->where('us_email', $email)->first();
        if ($dt) {
            $RSP['status'] = '200';
            $RSP['exist'] = true;
            $RSP['validate'] = $dt['us_validate'];
        } else {
            $RSP['status'] = '400';
            $RSP['exist'] = false;
        }

        return $RSP;
    }

    function validateUser()
    {
        $RSP = [];
        $model = new UserModel();
        $email = get('email');
        $code = get('code');
        $dt = $model->where('us_email', $email)->where('us_code', $code)->first();
        if ($dt) {
            $RSP['status'] = '200';
            $RSP['validate'] = true;
            $RSP['message'] = 'Usuário validado com sucesso.';
            $data = [
                'us_validate' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $model->update($dt['id_us'], $data);
        } else {
            $RSP['status'] = '400';
            $RSP['validate'] = false;
            $RSP['message'] = 'Código inválido.';
        }

        return $RSP;
    }

    public function show($id = null)
    {
        $model = new UserModel();
        $user = $model->find($id);
        if (!$user) {
            return $this->response->setJSON(['error' => 'Usuário não encontrado'])->setStatusCode(404);
        }
        return $this->response->setJSON($user);
    }

    public function create()
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $email = get('email');
        $name = get('fullname');
        $model = new UserModel();
        //$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data = [
            'us_email' => $email,
            'us_name' => $name,
            'us_password' => password_hash(bin2hex(random_bytes(4)), PASSWORD_DEFAULT),
            'us_code' => $code,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $dt = $model->where('us_email', $email)->first();
        if ($dt != null) {
            $RSP['status'] = '400';
            $RSP['message'] = 'Email já cadastrado.';
            $RSP['error'] = 'Email já cadastrado.';
        } else {
            // enviar email de confirmação
            $subject = "Bem-vindo ao Capagiic!";
            $message = "Olá $name,\n\nSeu cadastro foi realizado com sucesso!\n\nAtenciosamente,\nEquipe Capagiic";
            $message .= "\n\n(Esse é um email automático, por favor não responda)";
            $message .= "\n\nPara acessar o sistema, utilize seu email: $email";
            $message .= "\n\nSua codigo de acesso temporária é: " . $code;
            $RSP['status'] = '200';
            $RSP['code'] = $code;
            $RSP['message'] = 'Usuário criado com sucesso. Verifique seu email.';
            $RSP['message'] .= $message;
            $model->insert($data);
            //send_email($email, $name, $subject, $message);
        }
        return $RSP;
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        $model = new UserModel();
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $model->update($id, $data);
        return $this->response->setJSON(['message' => 'Usuário atualizado']);
    }

    public function delete($id = null)
    {
        $model = new UserModel();
        $model->delete($id);
        return $this->response->setJSON(['message' => 'Usuário deletado']);
    }
}
