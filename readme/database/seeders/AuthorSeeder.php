<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'first_name' => 'Laurent',
                'last_name' => 'Gounelle',
                'bio' => 'Auteur français de développement personnel, écrit des romans inspirants sur la transformation de soi.'
            ],
            [
                'first_name' => 'Hermann',
                'last_name' => 'Hesse',
                'bio' => 'Écrivain allemand, prix Nobel de littérature, auteur de Siddhartha et Le Loup des steppes.'
            ],
            [
                'first_name' => 'Mark',
                'last_name' => 'Manson',
                'bio' => 'Auteur américain, blogueur et entrepreneur, connu pour "L\'art subtil de s\'en foutre".'
            ],
            [
                'first_name' => 'Stefan',
                'last_name' => 'Zweig',
                'bio' => 'Écrivain autrichien du XXe siècle, maître de la nouvelle et du portrait psychologique.'
            ],
            [
                'first_name' => 'Victor',
                'last_name' => 'Hugo',
                'bio' => 'Écrivain français du XIXe siècle, auteur des Misérables et Notre-Dame de Paris.'
            ],
            [
                'first_name' => 'George',
                'last_name' => 'Orwell',
                'bio' => 'Écrivain britannique, auteur de 1984 et La Ferme des animaux.'
            ],
            [
                'first_name' => 'J.K.',
                'last_name' => 'Rowling',
                'bio' => 'Auteure britannique de la saga Harry Potter.'
            ],
            [
                'first_name' => 'Isaac',
                'last_name' => 'Asimov',
                'bio' => 'Écrivain américain de science-fiction, créateur des lois de la robotique.'
            ],
            [
                'first_name' => 'Albert',
                'last_name' => 'Camus',
                'bio' => 'Écrivain et philosophe français, prix Nobel de littérature.'
            ],
            [
                'first_name' => 'Stephen',
                'last_name' => 'King',
                'bio' => 'Maître américain du roman d\'horreur et de suspense.'
            ],
            [
                'first_name' => 'Haruki',
                'last_name' => 'Murakami',
                'bio' => 'Écrivain japonais contemporain, style unique mêlant réalisme et fantastique.'
            ],
            [
                'first_name' => 'Yuval Noah',
                'last_name' => 'Harari',
                'bio' => 'Historien israélien, auteur de Sapiens et Homo Deus.'
            ]
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
