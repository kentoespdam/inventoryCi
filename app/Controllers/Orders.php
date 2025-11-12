<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Orders extends BaseController
{
    public function index()
    {
        return view('order/index');
    }

    public function Arsip()
    {
        return view('order/arsip/index');
    }
}
