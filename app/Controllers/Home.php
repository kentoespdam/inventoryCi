<?php

namespace App\Controllers;

class Home extends BaseController
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
        return view('dashboard/index');
    }
}
