<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Nouvel Auteur</h1>
            <p class="text-gray-600 mt-2">Ajouter un nouvel auteur à la bibliothèque</p>
        </div>
        <a href="{{ route('admin.authors.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow-sm p-8">
            <form action="{{ route('admin.authors.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Prénom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="first_name" 
                           name="first_name" 
                           value="{{ old('first_name') }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror"
                           placeholder="Prénom de l'auteur">
                    @error('first_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="last_name" 
                           name="last_name" 
                           value="{{ old('last_name') }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror"
                           placeholder="Nom de l'auteur">
                    @error('last_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birth Year -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="birth_year" class="block text-sm font-medium text-gray-700 mb-2">
                            Année de naissance
                        </label>
                        <input type="number" 
                               id="birth_year" 
                               name="birth_year" 
                               value="{{ old('birth_year') }}"
                               min="1" 
                               max="{{ date('Y') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('birth_year') border-red-500 @enderror"
                               placeholder="Ex: 1920">
                        @error('birth_year')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Death Year -->
                    <div>
                        <label for="death_year" class="block text-sm font-medium text-gray-700 mb-2">
                            Année de décès
                        </label>
                        <input type="number" 
                               id="death_year" 
                               name="death_year" 
                               value="{{ old('death_year') }}"
                               min="1" 
                               max="{{ date('Y') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('death_year') border-red-500 @enderror"
                               placeholder="Ex: 1985">
                        @error('death_year')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Laissez vide si l'auteur est toujours vivant</p>
                    </div>
                </div>

                <!-- Biography -->
                <div>
                    <label for="biography" class="block text-sm font-medium text-gray-700 mb-2">
                        Biographie
                    </label>
                    <textarea id="biography" 
                              name="biography" 
                              rows="6"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('biography') border-red-500 @enderror"
                              placeholder="Biographie de l'auteur, ses œuvres principales, son style...">{{ old('biography') }}</textarea>
                    @error('biography')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Une courte biographie pour présenter l'auteur aux lecteurs</p>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t">
                    <a href="{{ route('admin.authors.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 font-medium transition duration-300">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition duration-300">
                        <i class="fas fa-save mr-2"></i>Créer l'auteur
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">
                        Conseils pour ajouter un auteur
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Vérifiez l'orthographe du nom et prénom avant de sauvegarder</li>
                            <li>La biographie aide les lecteurs à découvrir l'auteur</li>
                            <li>Les dates de naissance/décès sont optionnelles mais recommandées</li>
                            <li>Vous pourrez ajouter des livres à cet auteur après sa création</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const birthYearInput = document.getElementById('birth_year');
    const deathYearInput = document.getElementById('death_year');
    
    birthYearInput.addEventListener('change', function() {
        if (this.value) {
            deathYearInput.min = this.value;
        }
    });
    
    deathYearInput.addEventListener('change', function() {
        const birthYear = birthYearInput.value;
        if (birthYear && this.value && parseInt(this.value) < parseInt(birthYear)) {
            alert('L\'année de décès ne peut pas être antérieure à l\'année de naissance.');
            this.value = '';
        }
    });
});
</script>
</x-app-layout>
