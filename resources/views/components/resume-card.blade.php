<div class="border rounded-lg p-4 shadow hover:shadow-md transition bg-white dark:bg-gray-800">
    <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $resume->student->name }}</h3>
    <p class="text-sm text-gray-600 dark:text-gray-400">Spécialisation: {{ $resume->student->specialization->name ?? 'Non spécifiée' }}</p>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Ajouté le: {{ $resume->uploaded_at->format('d/m/Y') }}</p>
    <a href="{{ asset('storage/' . $resume->file_path) }}" target="_blank" class="block mt-4 text-blue-500 hover:underline">
        Voir le CV
    </a>
</div>
