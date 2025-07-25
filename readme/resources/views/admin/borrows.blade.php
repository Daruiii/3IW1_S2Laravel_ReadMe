<x-app-layout>
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Gestion des emprunts</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Utilisateur</th>
                <th class="px-4 py-2 border">Livre</th>
                <th class="px-4 py-2 border">Date début</th>
                <th class="px-4 py-2 border">Date fin</th>
                <th class="px-4 py-2 border">Statut</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrows as $borrow)
                <tr>
                    <td class="px-4 py-2 border">{{ $borrow->id }}</td>
                    <td class="px-4 py-2 border">{{ $borrow->user->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $borrow->book->title ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $borrow->date_start->format('d/m/Y') }}</td>
                    <td class="px-4 py-2 border">{{ $borrow->date_end->format('d/m/Y') }}</td>
                    <td class="px-4 py-2 border">{{ $borrow->status }}</td>
                    <td class="px-4 py-2 border">
                        @if($borrow->status === 'borrowed')
                            <form action="{{ route('admin.borrows.force-return', $borrow) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-blue-600 hover:underline">Retour forcé</button>
                            </form>
                        @else
                            <span class="text-gray-400">Retourné</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">Aucun emprunt trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $borrows->links() }}
    </div>
</div>
</x-app-layout>