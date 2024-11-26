@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-5">Welcome to the Resume Viewer</h1>

    <p class="text-center">
        Browse resumes by specialization, search for students, or upload a resume.
    </p>


    <!-- List of Specializations -->
    <h2 class="text-center mb-4">Specializations</h2>
    <div class="row">
        @foreach ($specializations as $specialization)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $specialization->name }}</h5>
                    <p class="card-text">{{ $specialization->description }}</p>
                    <a href="{{ route('specializations.show', $specialization->id) }}" class="btn btn-primary">View Resumes</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
