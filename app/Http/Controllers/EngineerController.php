<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EngineerController extends Controller
{
    public function index() {
        return view('dashboard.engineer.index');
    }
}
