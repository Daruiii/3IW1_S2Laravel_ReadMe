<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiction',
                'description' => 'Romans, nouvelles et oeuvres de fiction litteraire'
            ],
            [
                'name' => 'Science-Fiction',
                'description' => 'Litterature d\'anticipation et de science-fiction'
            ],
            [
                'name' => 'Fantastique',
                'description' => 'Romans fantastiques, fantasy et merveilleux'
            ],
            [
                'name' => 'Histoire',
                'description' => 'Ouvrages historiques et biographies'
            ],
            [
                'name' => 'Sciences',
                'description' => 'Livres scientifiques et techniques'
            ],
            [
                'name' => 'Philosophie',
                'description' => 'Oeuvres philosophiques et reflexions'
            ],
            [
                'name' => 'Art',
                'description' => 'Beaux-arts, architecture et design'
            ],
            [
                'name' => 'Cuisine',
                'description' => 'Livres de recettes et gastronomie'
            ],
            [
                'name' => 'Voyage',
                'description' => 'Guides de voyage et recits d\'aventure'
            ],
            [
                'name' => 'Developpement Personnel',
                'description' => 'Bien-etre, psychologie et developpement personnel'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
