@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-center text-2xl font-bold text-gray-800 dark:text-white mb-6">
        Ajouter un CV
    </h1>

    @if ($errors->any())
        <div class="mb-4 text-red-500">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('resumes.store') }}" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white p-6 shadow-md rounded-lg">
        @csrf

        <div class="mb-4">
            <label for="resume" class="block text-gray-700">Fichier CV (PDF uniquement):</label>
            <input type="file" name="resume" id="resume" class="mt-2 p-2 border border-gray-300 rounded w-full" required>
        </div>

        <div class="mb-4">
            <label for="student_name" class="block text-gray-700">Nom de l'étudiant:</label>
            <input type="text" name="student_name" id="student_name" class="mt-2 p-2 border border-gray-300 rounded w-full" required>
        </div>

        <div class="mb-4">
            <label for="student_email" class="block text-gray-700">Email de l'étudiant:</label>
            <input type="email" name="student_email" id="student_email" class="mt-2 p-2 border border-gray-300 rounded w-full" required>
        </div>

        <div class="mb-4">
            <label for="spec_id" class="block text-gray-700">Spécialisation:</label>
            <select name="spec_id" id="spec_id" class="mt-2 p-2 border border-gray-300 rounded w-full" required>
                <option value="" disabled selected>Choisissez une spécialisation</option>
                @foreach ($specializations as $specialization)
                    <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Ajouter le CV
        </button>
    </form>
</div>
@endsection
