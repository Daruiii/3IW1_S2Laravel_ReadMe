<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @php
            $isAdminView = request()->is('admin/*') || request()->routeIs('admin.dashboard');
        @endphp
        
        <nav class="{{ $isAdminView ? 'bg-gray-800' : 'bg-white' }} shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            @if($isAdminView)
                                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white">
                                    ReadMe Admin
                                </a>
                            @else
                                <a href="{{ route('books.index') }}" class="text-xl font-bold text-gray-800">
                                    ReadMe
                                </a>
                            @endif
                        </div>
                        <div class="hidden space-x-8 sm:ml-10 sm:flex sm:items-center">
                            @if($isAdminView && auth()->check() && auth()->user()->isAdmin())
                                <!-- Navigation Admin -->
                                <a href="{{ route('admin.dashboard') }}" class="border-transparent {{ $isAdminView ? 'text-gray-300 hover:text-white hover:border-gray-300' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Tableau de bord
                                </a>
                                <a href="{{ route('admin.books.index') }}" class="border-transparent {{ $isAdminView ? 'text-gray-300 hover:text-white hover:border-gray-300' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Livres
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="border-transparent {{ $isAdminView ? 'text-gray-300 hover:text-white hover:border-gray-300' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Utilisateurs
                                </a>
                                <a href="{{ route('admin.borrows.index') }}" class="border-transparent {{ $isAdminView ? 'text-gray-300 hover:text-white hover:border-gray-300' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Emprunts
                                </a>
                                <a href="{{ route('admin.categories.index') }}" class="border-transparent {{ $isAdminView ? 'text-gray-300 hover:text-white hover:border-gray-300' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Catégories
                                </a>
                                <a href="{{ route('admin.authors.index') }}" class="border-transparent {{ $isAdminView ? 'text-gray-300 hover:text-white hover:border-gray-300' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Auteurs
                                </a>
                            @else
                                <!-- Navigation Utilisateur -->
                                <a href="{{ route('books.index') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Catalogue
                                </a>
                                <a href="{{ route('categories.index') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Catégories
                                </a>
                                <a href="{{ route('authors.index') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Auteurs
                                </a>
                                @auth
                                    <a href="{{ route('borrows.index') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                        Mes emprunts
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                            Administration
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <div class="relative">
                                <div class="flex items-center space-x-4">
                                    @if($isAdminView)
                                        <a href="{{ route('books.index') }}" class="text-gray-300 hover:text-white">
                                            Retour au site
                                        </a>
                                        <span class="text-gray-300">{{ Auth::user()->name }}</span>
                                    @else
                                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                                            {{ Auth::user()->name }}
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="{{ $isAdminView ? 'text-gray-300 hover:text-white' : 'text-gray-500 hover:text-gray-700' }}">
                                            Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="space-x-4">
                                <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700">Connexion</a>
                                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    Inscription
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main>
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
