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
    
        // Build the query for filtering and searching
        $query = Resume::with('student.specialization');
    
        // Filter resumes based on specialization
        if ($request->filled('spec_filter')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('spec_id', $request->spec_filter);
            });
        }
    
        // Search resumes by student name or email
        if ($request->filled('search_query')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_query . '%')
                  ->orWhere('email', 'like', '%' . $request->search_query . '%');
            });
        }
    
        // Fetch the filtered and/or searched resumes
        $resumes = $query->latest()->get();
    
        return view('home', compact('specializations', 'resumes'));
    }    
}
