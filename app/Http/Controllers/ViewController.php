<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Config as FacadesConfig;
use Inertia\Inertia;
use PSpell\Config;

class ViewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
       $data = Image::with('post')->get();
       $baseUrl = FacadesConfig::get('app.url');
        return Inertia::render('view',[
            'data' => $data,
            'baseUrl' => $baseUrl,
        ]);
    }
}
