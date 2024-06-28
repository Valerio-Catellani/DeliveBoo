<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\API_request;

class HomeController extends Controller
{
    public function index()
    {
        $data = json_decode(file_get_contents(__DIR__ . '\..\..\..\database\seeders\json\Dishes.json'));
        $cat = json_decode(file_get_contents(__DIR__ . '\..\..\..\database\seeders\json\Typologies.json'));
        $rest = json_decode(file_get_contents(__DIR__ . '\..\..\..\database\seeders\json\Restaurants.json'));
        return view('home', compact('data', 'cat', 'rest'));
    }
}
