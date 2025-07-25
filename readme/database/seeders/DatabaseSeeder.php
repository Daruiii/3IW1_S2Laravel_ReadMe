<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ordre important : les dépendances d'abord !
        $this->call([
            CategorySeeder::class,  // Indépendant
            AuthorSeeder::class,    // Indépendant  
            UserSeeder::class,      // Indépendant
            BookSeeder::class,      // Dépend de Category et Author
        ]);
    }
}
