<x-app-layout>
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">Modifier l'utilisateur</h1>
    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block font-medium">Nom</label>
            <input type="text" name="name" id="name" class="border rounded w-full px-3 py-2" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block font-medium">Email</label>
            <input type="email" name="email" id="email" class="border rounded w-full px-3 py-2" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-4">
            <label for="is_admin" class="block font-medium">Administrateur</label>
            <input type="checkbox" name="is_admin" id="is_admin" value="1" @checked(old('is_admin', $user->role === 'admin'))>
        </div>
        <div class="mb-4">
            <label for="password" class="block font-medium">Nouveau mot de passe</label>
            <input type="password" name="password" id="password" class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block font-medium">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="border rounded w-full px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
</x-app-layout>