<?php

namespace App\Domains\Search\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController
{
    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Search/Index', [
            'searchQuery' => $request->get('q'),
            'results'     => [[], []],
        ]);
    }
}
