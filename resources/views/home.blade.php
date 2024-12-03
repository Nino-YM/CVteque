@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-center text-4xl font-bold text-gray-800 dark:text-white">
        Bienvenue dans la CVthèque de l'EPSI
    </h1>
    <p class="text-center text-gray-600 dark:text-gray-400 mt-4">
        Explorez et gérez les CVs des étudiants. Filtrez par spécialisation ou ajoutez un nouveau CV.
    </p>
    <div class="text-center mt-6">
        <a href="{{ route('resumes.create') }}" class="px-6 py-3 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Ajouter un CV
        </a>
    </div>

    <!-- Filter Dropdown -->
    <div class="mt-8">
        <form action="{{ route('home') }}" method="GET" class="text-center">
            <label for="spec_filter" class="block text-gray-700 dark:text-white mb-2">Filtrer par spécialisation:</label>
            <select name="spec_filter" id="spec_filter" class="p-2 border rounded">
                <option value="">Toutes les spécialisations</option>
                @foreach ($specializations as $specialization)
                    <option value="{{ $specialization->id }}" {{ request('spec_filter') == $specialization->id ? 'selected' : '' }}>
                        {{ $specialization->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition ml-2">
                Filtrer
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        @forelse ($resumes as $resume)
        <div class="border rounded-lg p-4 shadow hover:shadow-md transition bg-white dark:bg-gray-800">
            <div class="mb-4">
                <img 
                    src="{{ asset('storage/' . $resume->webp_path) }}" 
                    alt="Resume Thumbnail" 
                    class="w-full h-auto">
            </div>
            <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                {{ $resume->student->name ?? 'Nom inconnu' }}
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Spécialisation: {{ $resume->student->specialization->name ?? 'Non spécifiée' }}
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                Ajouté le: {{ optional($resume->uploaded_at)->format('d/m/Y') ?? 'Date inconnue' }}
            </p>
            <a href="{{ asset('storage/' . $resume->file_path) }}" 
            target="_blank" 
            class="block mt-4 text-blue-500 hover:underline">
                Voir le CV
            </a>
        </div>
        @empty
            <p class="text-center col-span-full text-gray-600 dark:text-gray-400">
                Aucun CV disponible pour cette spécialisation.
            </p>
        @endforelse
    </div>


@endsection
