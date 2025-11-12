<?php

namespace App\Controllers;

use App\Models\Master\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    use ResponseTrait;
    protected $modelName = UserModel::class;
    protected $type = "json";

    function __construct()
    {
        $this->session = service('session');
    }

    public function index()
    {
        return view('login/index');
    }

    public function login()
    {
        $body = (object) $this->request->getVar();

        $user = $this->model
            ->where([
                'user_login' => $body->username,
                // 'org_code' => 'BA9.2'
            ])
            // ->orWhere('org_code', 'BA4.3')
            ->first();

        // print_r($user);

        if (!$user) return redirect()->back()->withInput()->with('errors', "User tidak ditemukan!");
        if (!$user->doLogin($body->password)) return redirect()->back()->withInput()->with('errors', "User/Password Salah!!!");
        $this->session->set($user->generateToken());
        return redirect()->to('/');
        // return $this->respond(["data" => $user->generateToken(), "message" => "OK"]);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/Auth');
    }
}
