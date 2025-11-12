<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class Login extends BaseController
{
    public function index()
    {
        return view('login/index');
    }

    public function doLogin()
    {
        $data = (object)$this->request->getPost();
        $client = Services::curlrequest();

        $postData = [
            "username" => $data->username,
            "password" => $data->password
        ];
        $response = $client->request('post', 'http://report.laptop.net/Auth/login', ['json' => $postData]);
        if($response->getStatusCode()!==200){
            
        }
    }
}
