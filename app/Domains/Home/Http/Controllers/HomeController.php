<?php

namespace App\Domains\Home\Http\Controllers;

use Inertia\Inertia;

class HomeController
{

    public function index(): \Inertia\Response
    {
        return Inertia::render('Home/Index');
    }
}
