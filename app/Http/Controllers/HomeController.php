<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\APIrequest;

class HomeController extends Controller
{
    public function index()
    {
/*         $dataPath = DIR . DIRECTORYSEPARATOR . '..' . DIRECTORYSEPARATOR . '..' . DIRECTORYSEPARATOR . 'database' . DIRECTORYSEPARATOR . 'seeders' . DIRECTORYSEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'Dishes.json';
        $catPath = __DIR . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'Typologies.json';
        $restPath = __DIR . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'Restaurants.json';

        $data = json_decode(file_get_contents(__DIR . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'Dishes.json'));
        $cat = json_decode(file_get_contents($catPath));
        $rest = json_decode(file_get_contents($restPath)); */
        $data = $cat = $rest = [];
        return view('home', compact('data', 'cat', 'rest'));
    }
}