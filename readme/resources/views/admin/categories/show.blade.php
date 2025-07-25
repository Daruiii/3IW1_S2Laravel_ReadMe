<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
            <p class="text-gray-600 mt-2">Détails de la catégorie</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.categories.edit', $category) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-300">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('admin.categories.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-folder text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h2>
                        <p class="text-gray-600">Catégorie #{{ $category->id }}</p>
                    </div>
                </div>

                @if($category->description)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">
                        <i class="fas fa-align-left text-blue-600 mr-2"></i>Description
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed">{{ $category->description }}</p>
                    </div>
                </div>
                @endif

                <!-- Category Statistics -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $category->books->count() }}</div>
                        <div class="text-sm text-gray-600">Livre(s)</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $category->books->sum('available_copies') }}</div>
                        <div class="text-sm text-gray-600">Disponible(s)</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $category->books->sum('total_copies') }}</div>
                        <div class="text-sm text-gray-600">Total</div>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-orange-600">{{ $category->books->sum('total_copies') - $category->books->sum('available_copies') }}</div>
                        <div class="text-sm text-gray-600">Emprunté(s)</div>
                    </div>
                </div>

                <!-- Books in this Category -->
                @if($category->books->count() > 0)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-book text-blue-600 mr-2"></i>
                        Livres dans cette catégorie ({{ $category->books->count() }})
                    </h3>
                    <div class="space-y-4">
                        @foreach($category->books as $book)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded flex items-center justify-center">
                                    <i class="fas fa-book text-white text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $book->title }}</h4>
                                    <p class="text-sm text-gray-600">
                                        Par {{ $book->authors->pluck('first_name')->map(function($first, $key) use ($book) {
                                            return $first . ' ' . $book->authors[$key]->last_name;
                                        })->join(', ') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $book->publication_year }} • ISBN: {{ $book->isbn }}
                                    </p>
                                    <div class="flex items-center mt-1">
                                        @if($book->available_copies > 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                                {{ $book->available_copies }} disponible(s)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <span class="w-2 h-2 bg-red-400 rounded-full mr-1"></span>
                                                Non disponible
                                            </span>
                                        @endif
                                        <span class="ml-2 text-xs text-gray-500">
                                            {{ $book->total_copies }} exemplaire(s) total
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.books.show', $book) }}" 
                                   class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition duration-300">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.books.edit', $book) }}" 
                                   class="text-indigo-600 hover:text-indigo-800 p-2 rounded-lg hover:bg-indigo-50 transition duration-300">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun livre dans cette catégorie</h3>
                    <p class="text-gray-600 mb-4">Cette catégorie ne contient encore aucun livre.</p>
                    <a href="{{ route('admin.books.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition duration-300">
                        <i class="fas fa-plus mr-2"></i>Ajouter un livre
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-tools text-purple-600 mr-2"></i>Actions rapides
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="flex items-center w-full px-4 py-3 text-left bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition duration-300">
                        <i class="fas fa-edit mr-3"></i>Modifier cette catégorie
                    </a>
                    <a href="{{ route('admin.books.create') }}?category={{ $category->id }}" 
                       class="flex items-center w-full px-4 py-3 text-left bg-green-50 hover:bg-green-100 text-green-700 rounded-lg transition duration-300">
                        <i class="fas fa-plus mr-3"></i>Ajouter un livre
                    </a>
                    <a href="{{ route('admin.categories.create') }}" 
                       class="flex items-center w-full px-4 py-3 text-left bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg transition duration-300">
                        <i class="fas fa-folder-plus mr-3"></i>Nouvelle catégorie
                    </a>
                </div>
            </div>

            <!-- Category Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>Informations
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID</span>
                        <span class="font-medium">#{{ $category->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nom</span>
                        <span class="font-medium">{{ $category->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Créée le</span>
                        <span class="font-medium">{{ $category->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Modifiée le</span>
                        <span class="font-medium">{{ $category->updated_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Popular Authors in this Category -->
            @if($category->books->count() > 0)
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-user-edit text-orange-600 mr-2"></i>Auteurs populaires
                </h3>
                <div class="space-y-3">
                    @php
                        $authorCounts = [];
                        foreach($category->books as $book) {
                            foreach($book->authors as $author) {
                                $key = $author->id;
                                if (!isset($authorCounts[$key])) {
                                    $authorCounts[$key] = ['author' => $author, 'count' => 0];
                                }
                                $authorCounts[$key]['count']++;
                            }
                        }
                        $topAuthors = collect($authorCounts)->sortByDesc('count')->take(5);
                    @endphp
                    
                    @foreach($topAuthors as $authorData)
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">{{ $authorData['author']->first_name }} {{ $authorData['author']->last_name }}</p>
                            <p class="text-sm text-gray-600">{{ $authorData['count'] }} livre(s)</p>
                        </div>
                        <a href="{{ route('admin.authors.show', $authorData['author']) }}" 
                           class="text-blue-600 hover:text-blue-800 p-1 rounded transition duration-300">
                            <i class="fas fa-external-link-alt text-sm"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Danger Zone -->
            <div class="bg-white border border-red-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-red-900 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>Zone de danger
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    La suppression de cette catégorie est irréversible.
                    @if($category->books->count() > 0)
                        Attention : {{ $category->books->count() }} livre(s) sont associés à cette catégorie.
                    @endif
                </p>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? @if($category->books->count() > 0) {{ $category->books->count() }} livre(s) y sont associés. @endif Cette action est irréversible.')"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg font-medium transition duration-300"
                            @if($category->books->count() > 0) disabled @endif>
                        <i class="fas fa-trash mr-2"></i>Supprimer cette catégorie
                    </button>
                </form>
                @if($category->books->count() > 0)
                <p class="text-xs text-red-600 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Supprimez d'abord tous les livres de cette catégorie pour pouvoir la supprimer.
                </p>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>
