<?php

namespace App\Domains\Search\Http\Controllers;

use Inertia\Inertia;

class SearchController
{
    public function index(): \Inertia\Response
    {
        return Inertia::render('Search/Index', []);
    }
}
