@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-center text-2xl font-bold text-gray-800 dark:text-white mb-6">
        CV de {{ $resume->student->name ?? 'Nom inconnu' }}
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

    <div class="relative flex justify-center items-center">
        <!-- Left arrow -->
        @if (!empty($previousResume))
          <a href="{{ route('resumes.view', $previousResume->id) }}" 
            class="absolute left-0 px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition">
              ←
          </a>
        @else
          <span class="absolute left-0 px-4 py-2 bg-gray-400 text-white rounded-lg shadow cursor-not-allowed">
              ←
          </span>
        @endif

        <!-- Resume image -->
        <img 
            src="{{ asset('storage/' . $resume->webp_path) }}" 
            alt="Miniature du CV" 
            class="max-w-[600px] max-h-[800px] object-contain">
        
      <!-- Right arrow -->
      @if (!empty($nextResume))
        <a href="{{ route('resumes.view', $nextResume->id) }}" 
          class="absolute right-0 px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition">
            →
        </a>
      @else
        <span class="absolute right-0 px-4 py-2 bg-gray-400 text-white rounded-lg shadow cursor-not-allowed">
            →
        </span>
      @endif
    </div>

    <div class="text-center p-6 mt-4">
        <a href="{{ asset('storage/' . $resume->file_path) }}" 
           target="_blank" 
           class="px-6 py-3 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Ouvrir le PDF
        </a>
    </div>
</div>
@endsection
