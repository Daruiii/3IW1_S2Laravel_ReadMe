<x-app-layout>
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Ajouter un livre</h1>
    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.books.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="title" class="block font-medium">Titre</label>
            <input type="text" name="title" id="title" class="border rounded w-full px-3 py-2" value="{{ old('title') }}" required>
        </div>
        <div class="mb-4">
            <label for="summary" class="block font-medium">Résumé</label>
            <textarea name="summary" id="summary" class="border rounded w-full px-3 py-2">{{ old('summary') }}</textarea>
        </div>
        <div class="mb-4">
            <label for="year" class="block font-medium">Année</label>
            <input type="number" name="year" id="year" class="border rounded w-full px-3 py-2" value="{{ old('year') }}">
        </div>
        <div class="mb-4">
            <label for="stock" class="block font-medium">Stock</label>
            <input type="number" name="stock" id="stock" class="border rounded w-full px-3 py-2" value="{{ old('stock') }}" required>
        </div>
        <div class="mb-4">
            <label for="category_id" class="block font-medium">Catégorie</label>
            <select name="category_id" id="category_id" class="border rounded w-full px-3 py-2" required>
                <option value="">Sélectionner</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-medium">Auteurs</label>
            <div class="flex flex-wrap gap-2">
                @foreach($authors as $author)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="authors[]" value="{{ $author->id }}" @checked(collect(old('authors'))->contains($author->id))>
                        <span class="ml-2">{{ $author->full_name }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Ajouter</button>
    </form>
</div>
</x-app-layout>