<?php

namespace Modules\Dashboard\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        return view("Modules\Auth\Views\login");
    }
}
