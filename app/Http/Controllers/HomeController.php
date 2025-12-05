<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $institutes = Institute::with('departments')->get();
        return view('home', compact('institutes'));
    }
}
