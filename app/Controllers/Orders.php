<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Orders extends BaseController
{
    protected $session;
    public function __construct()
    {
        $this->session = service('session');
    }

    public function index()
    {
        if ($this->session->get("token") == null)
            return redirect()->to('/Auth');
        return view('order/index');
    }

    public function Arsip()
    {
        if ($this->session->get("token") == null)
            return redirect()->to('/Auth');
        return view('order/arsip/index');
    }
}
