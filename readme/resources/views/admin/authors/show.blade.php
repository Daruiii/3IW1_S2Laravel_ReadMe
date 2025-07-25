<x-app-layout>
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Auteur : {{ $author->full_name }}</h1>
    <div class="mb-4">
        <strong>Biographie :</strong>
        <div class="mt-1">{{ $author->bio }}</div>
    </div>
    <h2 class="text-xl font-semibold mt-6 mb-2">Livres associés</h2>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Titre</th>
                <th class="px-4 py-2 border">Catégorie</th>
                <th class="px-4 py-2 border">Année</th>
            </tr>
        </thead>
        <tbody>
            @forelse($author->books as $book)
                <tr>
                    <td class="px-4 py-2 border">{{ $book->title }}</td>
                    <td class="px-4 py-2 border">{{ $book->category->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $book->year }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4">Aucun livre associé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        <a href="{{ route('admin.authors.index') }}" class="text-blue-600 hover:underline">Retour à la liste</a>
    </div>
</div>
</x-app-layout>