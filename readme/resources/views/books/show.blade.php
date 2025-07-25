<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                <span>
                                    @foreach($book->authors as $author)
                                        <a href="{{ route('authors.show', $author) }}" class="hover:text-blue-600">
                                            {{ $author->full_name }}
                                        </a>{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </span>
                                <span>•</span>
                                <a href="{{ route('categories.show', $book->category) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $book->category->name }}
                                </a>
                                @if($book->year)
                                    <span>•</span>
                                    <span>{{ $book->year }}</span>
                                @endif
                            </div>
                        </div>
                        
                        @auth
                            @if(auth()->user()->isAdmin())
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.books.edit', $book) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>

                    @if($book->summary)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Résumé</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $book->summary }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Disponibilité</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>Stock total :</span>
                                    <span class="font-medium">{{ $book->stock }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Statut :</span>
                                    @if($book->stock > 0)
                                        <span class="text-green-600 font-medium">Disponible</span>
                                    @else
                                        <span class="text-red-600 font-medium">Non disponible</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($book->authors->isNotEmpty())
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Auteur(s)</h3>
                                <div class="space-y-2">
                                    @foreach($book->authors as $author)
                                        <div>
                                            <a href="{{ route('authors.show', $author) }}" class="font-medium text-blue-600 hover:text-blue-800">
                                                {{ $author->full_name }}
                                            </a>
                                            @if($author->bio)
                                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($author->bio, 100) }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    @auth
                        @php
                            $userAlreadyBorrowed = auth()->user()->activeBorrows()->where('book_id', $book->id)->exists();
                        @endphp
                        
                        @if($userAlreadyBorrowed)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-blue-800">Livre déjà emprunté</h3>
                                        <p class="text-sm text-blue-600">Vous avez déjà emprunté ce livre. Retournez-le depuis votre espace personnel.</p>
                                    </div>
                                    <a href="{{ route('borrows.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium">
                                        Mes emprunts
                                    </a>
                                </div>
                            </div>
                        @elseif($book->isAvailable() && auth()->user()->canBorrowBook())
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-green-800">Emprunter ce livre</h3>
                                        <p class="text-sm text-green-600">Durée d'emprunt : 30 jours</p>
                                    </div>
                                    <form method="POST" action="{{ route('borrows.store', $book) }}">
                                        @csrf
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium">
                                            Emprunter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @elseif(!$book->isAvailable())
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                <h3 class="text-lg font-medium text-red-800">Livre non disponible</h3>
                                <p class="text-sm text-red-600">Tous les exemplaires sont actuellement empruntés.</p>
                            </div>
                        @elseif(!auth()->user()->canBorrowBook())
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                <h3 class="text-lg font-medium text-yellow-800">Limite d'emprunts atteinte</h3>
                                <p class="text-sm text-yellow-600">Vous avez déjà emprunté 3 livres. Retournez un livre pour pouvoir en emprunter un nouveau.</p>
                            </div>
                        @endif
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-blue-800">Connectez-vous pour emprunter</h3>
                                    <p class="text-sm text-blue-600">Créez un compte ou connectez-vous pour emprunter des livres.</p>
                                </div>
                                <div class="space-x-2">
                                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Connexion
                                    </a>
                                    <a href="{{ route('register') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Inscription
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endauth

                    @if($book->activeBorrows->isNotEmpty() && auth()->check() && auth()->user()->isAdmin())
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Emprunts en cours</h3>
                            <div class="space-y-2">
                                @foreach($book->activeBorrows as $borrow)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200 last:border-b-0">
                                        <div>
                                            <span class="font-medium">{{ $borrow->user->name }}</span>
                                            <span class="text-sm text-gray-600 ml-2">
                                                Du {{ $borrow->date_start->format('d/m/Y') }} au {{ $borrow->date_end->format('d/m/Y') }}
                                            </span>
                                        </div>
                                        @if($borrow->isOverdue())
                                            <span class="text-red-600 text-sm font-medium">En retard</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            ← Retour au catalogue
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
