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


    public function edit($id)
    {
        $resume = Resume::with('student')->findOrFail($id);
        $specializations = Specialization::all();
        return view('resumes.edit', compact('resume', 'specializations'));
    }

    public function update(Request $request, $id)
    {
        $resume = Resume::with('student')->findOrFail($id);
    
        $request->validate([
            'student_name' => 'required|string|max:255',
            'student_email' => 'required|email|max:255|unique:students,email,' . $resume->student->id,
            'resume' => 'nullable|file|mimes:pdf|max:2048',
            'spec_id' => 'required|exists:specializations,id',
        ]);
    
        // Update student details
        $student = $resume->student;
        $student->name = $request->student_name;
        $student->email = $request->student_email;
        $student->spec_id = $request->spec_id;
        $student->save();
    
        // Replace the resume file if a new one is uploaded
        if ($request->hasFile('resume')) {
            // Delete the old resume
            Storage::delete('public/' . $resume->file_path);
    
            // Store the new resume
            $path = $request->file('resume')->store('resumes', 'public');
            $resume->file_path = $path;
    
            // Generate a new thumbnail
            $webpPath = str_replace('.pdf', '.webp', $path);
            exec("magick convert -density 300 \"{$pdfPath}[0]\" -background white -alpha remove -quality 100 \"{$webpPath}\"", $output, $returnVar);
            $resume->webp_path = $webpPath;
        }
    
        $resume->save();
    
        return redirect()->route('home')->with('success', 'CV modifié avec succès.');
    }
    

    public function destroy($id)
    {
        $resume = Resume::findOrFail($id);
    
        // Delete the resume file and its thumbnail
        Storage::delete('public/' . $resume->file_path);
        Storage::delete('public/' . $resume->webp_path);
    
        $student = $resume->student;
    
        // Delete the resume
        $resume->delete();
    
        // If the student has no other resumes, delete the student record
        if ($student->resumes()->count() === 0) {
            $student->delete();
        }
    
        return redirect()->route('home')->with('success', 'CV supprimé avec succès.');
    }
    
    public function view($id)
    {
        $resume = Resume::with('student')->findOrFail($id);
    
        // Fetch the previous and next resumes based on the current resume ID
        $previousResume = Resume::where('id', '<', $resume->id)->orderBy('id', 'desc')->first();
        $nextResume = Resume::where('id', '>', $resume->id)->orderBy('id', 'asc')->first();
    
        return view('resumes.view', compact('resume', 'previousResume', 'nextResume'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:2048',
            'spec_id' => 'required|exists:specializations,id',
            'student_name' => 'required|string|max:255',
            'student_email' => 'required|email|max:255',
        ]);

        // Check if a student with the provided email already exists
        $student = Student::where('email', $request->student_email)->first();

        if ($student) {
            // Warn the user if the email already exists
            $oldResumes = $student->resumes;

            // Remove old resumes associated with this student
            foreach ($oldResumes as $resume) {
                Storage::delete('public/' . $resume->file_path);
                Storage::delete('public/' . $resume->webp_path);
                $resume->delete();
            }
        } else {
            // Create a new student if no student exists
            $student = Student::create([
                'name' => $request->student_name,
                'email' => $request->student_email,
                'spec_id' => $request->spec_id,
            ]);
        }

        // Store the resume file
        $path = $request->file('resume')->store('resumes', 'public');

        // Convert PDF to WebP using ImageMagick
        $webpPath = str_replace('.pdf', '.webp', $path);
        $pdfPath = storage_path('app/public/' . $path);
        $webpFullPath = storage_path('app/public/' . $webpPath);

        exec("magick convert -density 300 \"{$pdfPath}[0]\" -background white -alpha remove -quality 100 \"{$webpFullPath}\"", $output, $returnVar);

        if ($returnVar !== 0) {
            return redirect()->back()->withErrors(['error' => 'Failed to generate the resume thumbnail.']);
        }

        // Save the new resume
        Resume::create([
            'student_id' => $student->id,
            'spec_id' => $request->spec_id,
            'file_path' => $path,
            'webp_path' => $webpPath,
            'uploaded_at' => now(),
        ]);

        return redirect()->route('home')->with('success', 'CV uploaded successfully. All previous CVs for this student were replaced.');
    }

}