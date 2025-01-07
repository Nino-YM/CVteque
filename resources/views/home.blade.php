@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-center text-4xl font-bold text-gray-800 dark:text-white">
        Liste des CVs
    </h1>
    <p class="text-center text-gray-600 dark:text-gray-400 mt-4">
        Explorez et gérez les CVs des étudiants. Filtrez par spécialisation ou ajoutez un nouveau CV.
    </p>
    <div class="text-center mt-6">
        <a href="{{ route('resumes.create') }}" class="px-6 py-3 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Ajouter un CV
        </a>
    </div>

    <!-- Search Bar -->
    <div class="mt-8">
        <form action="{{ route('home') }}" method="GET" class="text-center">
            <label for="search_query" class="block text-gray-700 dark:text-white mb-2">Rechercher un étudiant:</label>
            <input 
                type="text" 
                name="search_query" 
                id="search_query" 
                value="{{ request('search_query') }}" 
                placeholder="Nom ou email..." 
                class="p-2 border rounded w-64"
            >
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition ml-2">
                Rechercher
            </button>
        </form>
    </div>

    <!-- Filter Dropdown -->
    <div class="mt-8">
        <form action="{{ route('home') }}" method="GET" class="text-center">
            <label for="spec_filter" class="block text-gray-700 dark:text-white mb-2">Filtrer par spécialisation:</label>
            <select name="spec_filter" id="spec_filter" class="p-2 border rounded w-64">
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
            <div class="mb-4 flex justify-center items-center">
                <img 
                    src="{{ asset('storage/' . $resume->webp_path) }}" 
                    alt="Resume Thumbnail" 
                    class="max-w-[150px] max-h-[200px] object-contain">
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
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                Dernière mise à jour le: {{ optional($resume->updated_at)->format('d/m/Y') ?? 'Non modifié' }}
            </p>

            <div class="mt-4 flex justify-between">
                <a href="{{ route('resumes.edit', $resume->id) }}" 
                   class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-700 transition">
                    Modifier
                </a>
                <a href="{{ asset('storage/' . $resume->file_path) }}" 
                target="_blank" 
                class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Voir le CV
                </a>
                <form action="{{ route('resumes.destroy', $resume->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-700 transition"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce CV ?');">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
        @empty
            <p class="text-center col-span-full text-gray-600 dark:text-gray-400">
                Aucun CV disponible pour cette spécialisation.
            </p>
        @endforelse
    </div>
</div>
@endsection
