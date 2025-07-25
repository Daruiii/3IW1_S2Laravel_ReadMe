<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $book->title }}</h1>
            <p class="text-gray-600 mt-2">Détails du livre</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.books.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
                Retour à la liste
            </a>
            <a href="{{ route('admin.books.edit', $book) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                </svg>
                Modifier
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="lg:flex">
            <div class="lg:w-1/3 p-6">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full max-w-sm mx-auto rounded-lg shadow-md">
                @else
                    <div class="w-full max-w-sm mx-auto bg-gray-200 rounded-lg flex items-center justify-center h-80">
                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            
            <div class="lg:w-2/3 p-6">
                <div class="space-y-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations générales</h2>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Titre</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $book->title }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">ISBN</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $book->isbn ?? 'Non renseigné' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Année de publication</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $book->publication_year ?? 'Non renseignée' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Catégorie</dt>
                                <dd class="mt-1">
                                    @if($book->category)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $book->category->name }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-500">Non catégorisé</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Stock total</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $book->total_copies ?? 0 }} exemplaire(s)</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Statut</dt>
                                <dd class="mt-1">
                                    @if($book->isAvailable())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Disponible
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Indisponible
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    @if($book->authors->count() > 0)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Auteur(s)</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($book->authors as $author)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                        {{ $author->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($book->summary)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Résumé</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $book->summary }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Emprunts en cours</h3>
            </div>
            <div class="px-6 py-4">
                @if($currentBorrows->count() > 0)
                    <div class="space-y-4">
                        @foreach($currentBorrows as $borrow)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $borrow->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $borrow->user->email }}</p>
                                    <p class="text-xs text-gray-400">Emprunté le {{ $borrow->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div class="text-right">
                                    @if($borrow->due_date->isPast())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            En retard
                                        </span>
                                        <p class="text-xs text-red-600 mt-1">Retour prévu: {{ $borrow->due_date->format('d/m/Y') }}</p>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            En cours
                                        </span>
                                        <p class="text-xs text-gray-600 mt-1">Retour prévu: {{ $borrow->due_date->format('d/m/Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucun emprunt en cours</p>
                @endif
            </div>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Historique des emprunts</h3>
            </div>
            <div class="px-6 py-4">
                @if($borrowHistory->count() > 0)
                    <div class="space-y-4 max-h-80 overflow-y-auto">
                        @foreach($borrowHistory as $borrow)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $borrow->user->name }}</p>
                                    <p class="text-xs text-gray-400">
                                        {{ $borrow->date_start->format('d/m/Y') }} -
                                        @if($borrow->status === 'returned')
                                            {{ $borrow->date_end->format('d/m/Y') }}
                                        @else
                                            Non retourné
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    @if($borrow->status === 'returned')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Retourné
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Perdu/Non retourné
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucun historique d'emprunt</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-8 flex justify-end space-x-3">
        <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ? Cette action supprimera également tous les emprunts associés.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                Supprimer le livre
            </button>
        </form>
    </div>
</div>
</x-app-layout>
