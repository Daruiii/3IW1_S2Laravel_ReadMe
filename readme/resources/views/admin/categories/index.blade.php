<x-app-layout>
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Catégories</h1>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
    @endif
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Nom</th>
                <th class="px-4 py-2 border">Description</th>
                <th class="px-4 py-2 border">Livres</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td class="px-4 py-2 border">{{ $category->id }}</td>
                    <td class="px-4 py-2 border">{{ $category->name }}</td>
                    <td class="px-4 py-2 border">{{ $category->description }}</td>
                    <td class="px-4 py-2 border">{{ $category->books_count }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-600 hover:underline">Voir</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Aucune catégorie trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $categories->links() }}</div>
</div>
</x-app-layout>