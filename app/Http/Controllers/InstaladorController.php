<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstaladorController extends Controller
{
    public function index()
    {
        return view('instalador.dashboard');
    }
}
