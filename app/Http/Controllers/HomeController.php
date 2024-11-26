<?php

namespace App\Http\Controllers;

use App\Models\Specialization;

class HomeController extends Controller
{
    public function index()
    {
        $specializations = Specialization::all();

        return view('home', compact('specializations'));
    }
}
