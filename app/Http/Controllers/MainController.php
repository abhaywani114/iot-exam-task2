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
    public function unauthorized() {
        $msg = ["success" => false, "msg" =>	"Unauthorized access: your current role doesn't have the privildge to visit this route"];
        return view('message', compact('msg'));
    }
}
