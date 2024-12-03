<?php

namespace App\Http\Controllers;

use Imagick;
use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Specialization;

class ResumeController extends Controller
{
    public function create()
    {
        $specializations = Specialization::all(); // Fetch all specializations
        $students = Student::with('resumes')->get(); // Ensure we load relationships like `spec_id`
        return view('resumes.create', compact('specializations', 'students'));
    }  



    public function store(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:2048',
            'spec_id' => 'required|exists:specializations,id',
            'student_id' => 'nullable|exists:students,id',
            'new_student_name' => 'nullable|string|max:255',
            'new_student_email' => 'nullable|email|max:255|unique:students,email',
        ]);

        // Handle student selection or creation
        if ($request->filled('new_student_name') && $request->filled('new_student_email')) {
            $student = Student::create([
                'name' => $request->new_student_name,
                'email' => $request->new_student_email,
            ]);
        } elseif ($request->filled('student_id')) {
            $student = Student::find($request->student_id);
            if ($student->spec_id !== $request->spec_id) {
                $student->update(['spec_id' => $request->spec_id]);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Please select an existing student or enter new student details.']);
        }

        // Store the resume file
        $path = $request->file('resume')->store('resumes', 'public');

        // Convert PDF to WebP using ImageMagick
        $webpPath = str_replace('.pdf', '.webp', $path);
        $pdfPath = storage_path('app/public/' . $path);
        $webpFullPath = storage_path('app/public/' . $webpPath);

        // Execute the ImageMagick command
        exec("magick convert -density 150 \"{$pdfPath}[0]\" \"{$webpFullPath}\"", $output, $returnVar);

        if ($returnVar !== 0) {
            return redirect()->back()->withErrors(['error' => 'Failed to generate the resume thumbnail.']);
        }

        // Save the resume
        Resume::create([
            'student_id' => $student->id,
            'spec_id' => $request->spec_id,
            'file_path' => $path,
            'webp_path' => $webpPath, // Add this field in your migration
            'uploaded_at' => now(),
        ]);

        return redirect()->route('home')->with('success', 'CV uploaded successfully.');
    }

}