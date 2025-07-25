<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Catalogue des livres</h2>
                        @auth
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <a href="{{ route('admin.books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">Ajouter un livre</a>
                            @endif
                        @endauth
                    </div>

                    <div class="mb-6">
                        <form method="GET" class="flex flex-wrap gap-4">
                            <div class="flex-1 min-w-64">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Rechercher par titre ou auteur..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <select name="category_id" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="author_id" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Tous les auteurs</option>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}" {{ request('author_id') == $author->id ? 'selected' : '' }}>
                                            {{ $author->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="sort" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Titre</option>
                                    <option value="year" {{ request('sort') == 'year' ? 'selected' : '' }}>Année</option>
                                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date d'ajout</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Filtrer
                            </button>
                            @if(request()->hasAny(['search', 'category_id', 'author_id', 'sort']))
                                <a href="{{ route('books.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                                    Réinitialiser
                                </a>
                            @endif
                        </form>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($books as $book)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('books.show', $book) }}" class="hover:text-blue-600">
                                            {{ $book->title }}
                                        </a>
                                    </h3>
                                    
                                    <p class="text-sm text-gray-600 mb-2">
                                        @foreach($book->authors as $author)
                                            <span class="inline-block">{{ $author->full_name }}</span>{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </p>
                                    
                                    <p class="text-sm text-blue-600 mb-3">{{ $book->category->name }}</p>
                                    
                                    @if($book->year)
                                        <p class="text-sm text-gray-500 mb-3">{{ $book->year }}</p>
                                    @endif
                                    
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm">
                                            @if($book->stock > 0)
                                                <span class="text-green-600 font-medium">{{ $book->stock }} disponible(s)</span>
                                            @else
                                                <span class="text-red-600 font-medium">Non disponible</span>
                                            @endif
                                        </div>
                                        
                                        @auth
                                            @php
                                                $userAlreadyBorrowed = auth()->user()->activeBorrows()->where('book_id', $book->id)->exists();
                                            @endphp
                                            
                                            @if($userAlreadyBorrowed)
                                                <span class="text-blue-600 text-sm font-medium">Déjà emprunté</span>
                                            @elseif($book->isAvailable() && auth()->user()->canBorrowBook())
                                                <form method="POST" action="{{ route('borrows.store', $book) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                        Emprunter
                                                    </button>
                                                </form>
                                            @elseif(!$book->isAvailable())
                                                <span class="text-red-600 text-sm font-medium">Non disponible</span>
                                            @elseif(!auth()->user()->canBorrowBook())
                                                <span class="text-yellow-600 text-sm font-medium">Limite atteinte</span>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500 text-lg">Aucun livre trouvé.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
