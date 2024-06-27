<?php

namespace App\Domains\Estate\Http\Controllers;

use Inertia\Inertia;

class PersonalEstateController
{

    public function index(): \Inertia\Response
    {
        return Inertia::render('Personal/Estate/Index');
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Personal/Estate/Create');
    }
}
