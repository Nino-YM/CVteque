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
    
        // Start building the query
        $query = Resume::with('student.specialization');
    
        // Apply specialization filter if selected
        if ($request->filled('spec_filter')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('spec_id', $request->spec_filter);
            });
        }
    
        // Execute the query and fetch resumes
        $resumes = $query->latest()->get();
    
        return view('home', compact('specializations', 'resumes'));
    }
}
