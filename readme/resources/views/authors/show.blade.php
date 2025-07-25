<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $author->full_name }}</h1>
                    
                    @if($author->bio)
                        <p class="text-gray-600 mb-4 leading-relaxed">{{ $author->bio }}</p>
                    @endif
                    
                    <p class="text-sm text-blue-600">{{ $books->total() }} livre(s) de cet auteur</p>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Livres</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($books as $book)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('books.show', $book) }}" class="hover:text-blue-600">
                                            {{ $book->title }}
                                        </a>
                                    </h3>
                                    
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
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500 text-lg">Aucun livre de cet auteur.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <div class="mt-8">
                        {{ $books->links() }}
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('authors.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            ← Retour aux auteurs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
