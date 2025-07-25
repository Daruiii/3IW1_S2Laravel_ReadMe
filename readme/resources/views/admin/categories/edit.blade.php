<x-app-layout>
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Modifier la catégorie</h1>
    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block font-medium">Nom</label>
            <input type="text" name="name" id="name" class="border rounded w-full px-3 py-2" value="{{ old('name', $category->name) }}" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block font-medium">Description</label>
            <textarea name="description" id="description" class="border rounded w-full px-3 py-2">{{ old('description', $category->description) }}</textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
</x-app-layout>