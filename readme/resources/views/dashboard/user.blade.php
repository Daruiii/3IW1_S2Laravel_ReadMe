<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Tableau de bord</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800 mb-2">Livres empruntés</h3>
                            <p class="text-3xl font-bold text-blue-600">{{ $stats['borrowed_books'] }}</p>
                            <p class="text-sm text-blue-600">sur 3 maximum</p>
                        </div>
                        
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-2">Total emprunts</h3>
                            <p class="text-3xl font-bold text-green-600">{{ $stats['total_borrows'] }}</p>
                            <p class="text-sm text-green-600">depuis votre inscription</p>
                        </div>
                        
                        <div class="bg-red-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-red-800 mb-2">Livres en retard</h3>
                            <p class="text-3xl font-bold text-red-600">{{ $stats['overdue_books'] }}</p>
                            <p class="text-sm text-red-600">à retourner rapidement</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($current_borrows->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Emprunts en cours</h3>
                        <div class="space-y-4">
                            @foreach($current_borrows as $borrow)
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg {{ $borrow->isOverdue() ? 'bg-red-50 border-red-200' : '' }}">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">
                                            <a href="{{ route('books.show', $borrow->book) }}" class="hover:text-blue-600">
                                                {{ $borrow->book->title }}
                                            </a>
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            @foreach($borrow->book->authors as $author)
                                                {{ $author->full_name }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $borrow->book->category->name }}</p>
                                    </div>
                                    <div class="ml-4 text-right">
                                        <p class="text-sm font-medium {{ $borrow->isOverdue() ? 'text-red-600' : 'text-gray-900' }}">
                                            À retourner le {{ $borrow->date_end->format('d/m/Y') }}
                                        </p>
                                        @if($borrow->isOverdue())
                                            <p class="text-xs text-red-600 font-medium">En retard</p>
                                        @endif
                                        <div class="mt-2">
                                            <form method="POST" action="{{ route('borrows.return', $borrow) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                    Retourner
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if($recent_returns->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Retours récents</h3>
                        <div class="space-y-3">
                            @foreach($recent_returns as $borrow)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $borrow->book->title }}</h4>
                                        <p class="text-sm text-gray-600">
                                            @foreach($borrow->book->authors as $author)
                                                {{ $author->full_name }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Retourné</p>
                                        <p class="text-xs text-gray-400">{{ $borrow->updated_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-8 text-center">
                <a href="{{ route('books.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium">
                    Explorer le catalogue
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
