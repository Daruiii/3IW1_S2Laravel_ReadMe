<x-app-layout>
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">Admin Dashboard</h2>
        </div>
        <div class="mt-4">
            <!-- Add your dashboard content here -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-medium">Welcome, Admin!</h3>
                <p class="text-gray-600 mt-2">Here you can manage the ReadMe application effectively.</p>
                <div class="mt-4">
                    <!-- Sample stats or quick links -->
                    <ul class="list-disc pl-5">
                        <li>Total Users: {{ $stats['total_users'] }}</li>
                        <li>Total Books: {{ $stats['total_books'] }}</li>
                        <li>Active Borrows: {{ $stats['active_borrows'] }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
