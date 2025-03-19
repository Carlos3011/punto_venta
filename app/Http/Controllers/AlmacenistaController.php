<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlmacenistaController extends Controller
{
    public function index()
    {
        return view('almacenista.dashboard');
    }
}
