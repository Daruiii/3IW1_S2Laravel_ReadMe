<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Auteurs</h1>
            <p class="text-gray-600 mt-2">Administrer la liste des auteurs de la bibliothèque</p>
        </div>
        <a href="{{ route('admin.authors.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-300">
            <i class="fas fa-plus mr-2"></i>Nouvel Auteur
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Auteurs</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $authors->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-book text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Livres Associés</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $authors->sum(function($author) { return $author->books_count; }) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-star text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Auteurs Populaires</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $authors->where('books_count', '>=', 3)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <form method="GET" action="{{ route('admin.authors.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Rechercher un auteur
                    </label>
                    <input type="text" id="search" name="search" 
                           value="{{ request('search') }}"
                           placeholder="Nom, prénom..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">
                        Trier par
                    </label>
                    <select id="sort" name="sort" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="first_name" {{ request('sort') == 'first_name' ? 'selected' : '' }}>Prénom</option>
                        <option value="last_name" {{ request('sort') == 'last_name' ? 'selected' : '' }}>Nom</option>
                        <option value="books_count" {{ request('sort') == 'books_count' ? 'selected' : '' }}>Nombre de livres</option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date d'ajout</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full bg-gray-800 hover:bg-gray-900 text-white px-6 py-2 rounded-lg font-medium transition duration-300">
                        <i class="fas fa-search mr-2"></i>Rechercher
                    </button>
                </div>
            </div>

            @if(request()->hasAny(['search', 'sort']))
                <div class="flex justify-between items-center pt-4 border-t">
                    <p class="text-sm text-gray-600">
                        {{ $authors->total() }} résultat(s) trouvé(s)
                    </p>
                    <a href="{{ route('admin.authors.index') }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Réinitialiser les filtres
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Authors Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Auteur
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Biographie
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Livres
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date d'ajout
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($authors as $author)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $author->first_name }} {{ $author->last_name }}
                                        </div>
                                        @if($author->birth_year)
                                            <div class="text-sm text-gray-500">
                                                Né(e) en {{ $author->birth_year }}
                                                @if($author->death_year)
                                                    - {{ $author->death_year }}
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                    {{ $author->biography ? Str::limit($author->biography, 100) : 'Aucune biographie' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $author->books_count ?? 0 }} livre(s)
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $author->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.authors.show', $author) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.authors.edit', $author) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.authors.destroy', $author) }}" 
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet auteur ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-users text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Aucun auteur trouvé</p>
                                    <p class="mt-2">Commencez par ajouter votre premier auteur.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($authors->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $authors->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
</x-app-layout>