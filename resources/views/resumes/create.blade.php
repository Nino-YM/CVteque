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
          <label for="student_id" class="block text-gray-700">Étudiant existant:</label>
          <select name="student_id" id="student_id" class="mt-2 p-2 border border-gray-300 rounded w-full">
              <option value="" selected>Choisissez un étudiant existant</option>
              @foreach ($students as $student)
                  <option 
                      value="{{ $student->id }}" 
                      data-spec-id="{{ $student->spec_id ?? '' }}">{{ $student->name }} ({{ $student->email }})
                  </option>
              @endforeach
          </select>
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

      <p class="text-center text-gray-600 dark:text-gray-400 mb-4">OU</p>

      <div class="mb-4">
          <label for="new_student_name" class="block text-gray-700">Nom du nouvel étudiant:</label>
          <input placeholder="NOM Prénom" type="text" name="new_student_name" id="new_student_name" class="mt-2 p-2 border border-gray-300 rounded w-full">
      </div>

      <div class="mb-4">
          <label for="new_student_email" class="block text-gray-700">Email du nouvel étudiant:</label>
          <input type="email" name="new_student_email" id="new_student_email" class="mt-2 p-2 border border-gray-300 rounded w-full">
      </div>

      <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition">
          Envoyer
      </button>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      const studentSelect = document.getElementById('student_id');
      const specializationSelect = document.getElementById('spec_id');

      studentSelect.addEventListener('change', function () {
          const selectedOption = studentSelect.options[studentSelect.selectedIndex];
          const specId = selectedOption.getAttribute('data-spec-id');

          console.log("Selected spec_id: ", specId); // Debugging

          // Update the specialization dropdown
          if (specId) {
              specializationSelect.value = specId; // Match the value to set the correct option
          } else {
              specializationSelect.value = ""; // Reset if no specialization is found
          }
      });
  });
</script>

@endsection
