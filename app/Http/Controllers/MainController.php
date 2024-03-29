<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function homepage() {
        return view('dashboard.dashboard');
    }
    public function dashboard() {
        return view('dashboard.dashboard');
    }
}
