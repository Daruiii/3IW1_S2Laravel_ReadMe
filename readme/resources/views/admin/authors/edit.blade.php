<x-app-layout>
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Modifier l'auteur</h1>
    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.authors.update', $author) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="first_name" class="block font-medium">Prénom</label>
            <input type="text" name="first_name" id="first_name" class="border rounded w-full px-3 py-2" value="{{ old('first_name', $author->first_name) }}" required>
        </div>
        <div class="mb-4">
            <label for="last_name" class="block font-medium">Nom</label>
            <input type="text" name="last_name" id="last_name" class="border rounded w-full px-3 py-2" value="{{ old('last_name', $author->last_name) }}" required>
        </div>
        <div class="mb-4">
            <label for="bio" class="block font-medium">Biographie</label>
            <textarea name="bio" id="bio" class="border rounded w-full px-3 py-2">{{ old('bio', $author->bio) }}</textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
</x-app-layout>
