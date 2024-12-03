<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Resume;
use App\Models\Specialization;
use Illuminate\Http\Request;


class HomeController extends Controller
{   
    public function index(Request $request)
    {
        // Fetch specializations for the filter dropdown
        $specializations = Specialization::all();
    
        // Filter resumes based on specialization
        $query = Resume::with('student.specialization');
    
        if ($request->filled('spec_filter')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('spec_id', $request->spec_filter);
            });
        }
    
        $resumes = Resume::with('student.specialization')->latest()->get();
    
        return view('home', compact('specializations', 'resumes'));
    }
    
}
