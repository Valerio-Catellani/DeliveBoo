<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\API_request;

class HomeController extends Controller
{
    public function index()
    {
        $data = json_decode(file_get_contents(__DIR__ . '\..\..\..\database\seeders\Dishes.json'));
        $cat = json_decode(file_get_contents(__DIR__ . '\..\..\..\database\seeders\Categories.json'));
        return view('home', compact('data', 'cat'));
    }
}
