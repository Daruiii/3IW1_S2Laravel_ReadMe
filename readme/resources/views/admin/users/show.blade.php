<x-app-layout>
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Retour à la liste</span>
            </a>
            <div class="h-6 border-l border-gray-300"></div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $user->first_name }} {{ $user->last_name }}
                </h1>
                <p class="text-gray-600 mt-1">
                    @if($user->is_admin)
                        <i class="fas fa-user-shield mr-1"></i>Administrateur
                    @else
                        <i class="fas fa-user mr-1"></i>Utilisateur
                    @endif
                    - Inscrit {{ $user->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-300">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Informations personnelles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-medium text-lg">
                                    {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <div class="text-lg font-medium text-gray-900">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </div>
                                <div class="text-sm text-gray-500">ID: #{{ $user->id }}</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-3"></i>
                            <a href="mailto:{{ $user->email }}" 
                               class="text-blue-600 hover:text-blue-800 transition duration-300">
                                {{ $user->email }}
                            </a>
                        </div>
                    </div>
                    @if($user->phone)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-gray-400 mr-3"></i>
                            <a href="tel:{{ $user->phone }}" 
                               class="text-blue-600 hover:text-blue-800 transition duration-300">
                                {{ $user->phone }}
                            </a>
                        </div>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                        <div class="flex items-center">
                            @if($user->is_admin)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-user-shield mr-2"></i>Administrateur
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-user mr-2"></i>Utilisateur
                                </span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date d'inscription</label>
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-gray-400 mr-3"></i>
                            <div>
                                <div class="text-gray-900">{{ $user->created_at->format('d/m/Y à H:i') }}</div>
                                <div class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dernière mise à jour</label>
                        <div class="flex items-center">
                            <i class="fas fa-clock text-gray-400 mr-3"></i>
                            <div>
                                <div class="text-gray-900">{{ $user->updated_at->format('d/m/Y à H:i') }}</div>
                                <div class="text-sm text-gray-500">{{ $user->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Borrows -->
            @if($currentBorrows->count() > 0)
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">
                    Emprunts en cours ({{ $currentBorrows->count() }})
                </h2>
                <div class="space-y-4">
                    @foreach($currentBorrows as $borrow)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">
                                        <a href="{{ route('admin.books.show', $borrow->book) }}" 
                                           class="hover:text-blue-600 transition duration-300">
                                            {{ $borrow->book->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        par {{ $borrow->book->authors->pluck('name')->join(', ') }}
                                    </p>
                                    <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                        <span>
                                            <i class="fas fa-calendar-plus mr-1"></i>
                                            Emprunté le {{ $borrow->created_at->format('d/m/Y') }}
                                        </span>
                                        <span>
                                            <i class="fas fa-calendar-times mr-1"></i>
                                            À rendre le {{ $borrow->due_date->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                @php
                                    $daysLeft = now()->diffInDays($borrow->due_date, false);
                                @endphp
                                @if($daysLeft < 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        En retard ({{ abs($daysLeft) }} jour{{ abs($daysLeft) > 1 ? 's' : '' }})
                                    </span>
                                @elseif($daysLeft <= 3)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $daysLeft }} jour{{ $daysLeft > 1 ? 's' : '' }} restant{{ $daysLeft > 1 ? 's' : '' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>
                                        {{ $daysLeft }} jour{{ $daysLeft > 1 ? 's' : '' }} restant{{ $daysLeft > 1 ? 's' : '' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Borrow History -->
            @if($borrowHistory->count() > 0)
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">
                    Historique des emprunts ({{ $borrowHistory->count() }} derniers)
                </h2>
                <div class="space-y-3">
                    @foreach($borrowHistory as $borrow)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-book text-gray-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">
                                    <a href="{{ route('admin.books.show', $borrow->book) }}" 
                                       class="hover:text-blue-600 transition duration-300">
                                        {{ $borrow->book->title }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-600">
                                    {{ $borrow->created_at->format('d/m/Y') }} - 
                                    {{ $borrow->status === 'returned' ? $borrow->date_end->format('d/m/Y') : 'En cours' }}
                                </p>
                            </div>
                        </div>
                        <div>
                            @if($borrow->status === 'returned')
                                @php
                                    $duration = $borrow->created_at->diffInDays($borrow->date_end);
                                @endphp
                                <span class="text-sm text-gray-500">
                                    {{ $duration }} jour{{ $duration > 1 ? 's' : '' }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    En cours
                                </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($user->borrows()->count() > $borrowHistory->count())
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.borrows.index', ['user' => $user->id]) }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium transition duration-300">
                        Voir tous les emprunts ({{ $user->borrows()->count() }})
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Emprunts totaux</span>
                        <span class="font-semibold text-gray-900">{{ $user->borrows()->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Emprunts en cours</span>
                        <span class="font-semibold text-orange-600">{{ $currentBorrows->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Emprunts terminés</span>
                        <span class="font-semibold text-green-600">{{ $user->borrows()->where('status', 'returned')->count() }}</span>
                    </div>
                    @php
                        $overdueBorrows = $user->borrows()
                            ->where('status', 'borrowed')
                            ->where('due_date', '<', now())
                            ->count();
                    @endphp
                    @if($overdueBorrows > 0)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">En retard</span>
                        <span class="font-semibold text-red-600">{{ $overdueBorrows }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition duration-300">
                        <i class="fas fa-edit mr-2"></i>Modifier l'utilisateur
                    </a>
                    <a href="{{ route('admin.borrows.index', ['user' => $user->id]) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition duration-300">
                        <i class="fas fa-book mr-2"></i>Voir tous les emprunts
                    </a>
                    <a href="mailto:{{ $user->email }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition duration-300">
                        <i class="fas fa-envelope mr-2"></i>Envoyer un email
                    </a>
                </div>
            </div>

            <!-- Account Status -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statut du compte</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-gray-700">Compte actif</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">Email vérifié</span>
                    </div>
                    @if($user->is_admin)
                    <div class="flex items-center">
                        <i class="fas fa-user-shield text-purple-500 mr-3"></i>
                        <span class="text-gray-700">Privilèges administrateur</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Danger Zone -->
            @if(!$user->is_admin || auth()->user()->id !== $user->id)
            <div class="bg-white rounded-lg shadow-sm p-6 border border-red-200">
                <h3 class="text-lg font-semibold text-red-900 mb-4">Zone de danger</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Cette action supprimera définitivement le compte utilisateur et toutes ses données associées.
                </p>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible et supprimera également tous ses emprunts.')"
                            class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition duration-300">
                        <i class="fas fa-trash mr-2"></i>Supprimer l'utilisateur
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
