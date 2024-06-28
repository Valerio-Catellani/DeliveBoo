<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($slug)
    {
        if ($slug != Auth::user()->slug) {
            return redirect()->route('admin.dashboard', ['user_slug' => Auth::user()->slug]);
        };
        return view('admin.dashboard', ['user_slug' => Auth::user()->slug]);
    }
}
