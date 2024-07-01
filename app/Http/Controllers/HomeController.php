<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\API_request;

class HomeController extends Controller
{
    public function index()
    {
/*         $dataPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'Dishes.json';
        $catPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'Typologies.json';
        $restPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'Restaurants.json';

        $data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'Dishes.json'));
        $cat = json_decode(file_get_contents($catPath));
        $rest = json_decode(file_get_contents($restPath)); */
        $data = $cat = $rest = [];
        return view('home', compact('data', 'cat', 'rest'));
    }
}