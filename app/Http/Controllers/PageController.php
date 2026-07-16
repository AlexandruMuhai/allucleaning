<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController
{
    public function index(): View
    {
        return view('index');
    }

    public function oferta(): View
    {
        return view('oferta');
    }

    public function oNas(): View
    {
        return view('o-nas');
    }

    public function kontakt(): View
    {
        return view('kontakt', [
            'serviceTypes' => ContactRequest::serviceTypes(),
        ]);
    }
}
