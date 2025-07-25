<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Nouveau Livre</h1>
            <p class="text-gray-600 mt-2">Ajouter un nouveau livre à la bibliothèque</p>
        </div>
        <a href="{{ route('admin.books.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow-sm p-8">
            <form action="{{ route('admin.books.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Titre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                           placeholder="Titre du livre">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Summary -->
                <div>
                    <label for="summary" class="block text-sm font-medium text-gray-700 mb-2">
                        Résumé
                    </label>
                    <textarea id="summary" 
                              name="summary" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('summary') border-red-500 @enderror"
                              placeholder="Résumé du livre">{{ old('summary') }}</textarea>
                    @error('summary')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Year -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                        Année de publication
                    </label>
                    <input type="number" 
                           id="year" 
                           name="year" 
                           value="{{ old('year') }}"
                           min="1000"
                           max="{{ date('Y') + 1 }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('year') border-red-500 @enderror"
                           placeholder="Ex: {{ date('Y') }}">
                    @error('year')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Stock <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="stock" 
                           name="stock" 
                           value="{{ old('stock') }}"
                           required
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock') border-red-500 @enderror"
                           placeholder="Nombre d'exemplaires">
                    @error('stock')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" 
                            name="category_id" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Authors -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Auteurs <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3 max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-4">
                        @foreach($authors as $author)
                            <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" 
                                       name="authors[]" 
                                       value="{{ $author->id }}" 
                                       @checked(collect(old('authors'))->contains($author->id))
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm text-gray-700">{{ $author->full_name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('authors')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.books.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition duration-300">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition duration-300">
                        <i class="fas fa-plus mr-2"></i>Ajouter le livre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>