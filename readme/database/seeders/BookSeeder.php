<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            // Livres de Laurent Gounelle
            [
                'title' => 'L\'homme qui voulait être heureux',
                'summary' => 'Un homme rencontre un guérisseur balinais qui va changer sa vision de la vie.',
                'year' => 2008,
                'stock' => 3,
                'category' => 'Développement Personnel',
                'authors' => ['Laurent Gounelle']
            ],
            [
                'title' => 'Les dieux voyagent toujours incognito',
                'summary' => 'Un roman initiatique sur la découverte de soi et le dépassement des limites.',
                'year' => 2010,
                'stock' => 2,
                'category' => 'Développement Personnel',
                'authors' => ['Laurent Gounelle']
            ],
            // Livres d\'Hermann Hesse
            [
                'title' => 'Siddhartha',
                'summary' => 'Le voyage spirituel d\'un homme à la recherche de l\'illumination.',
                'year' => 1922,
                'stock' => 4,
                'category' => 'Philosophie',
                'authors' => ['Hermann Hesse']
            ],
            [
                'title' => 'Le Loup des steppes',
                'summary' => 'Portrait d\'un intellectuel en crise existentielle dans l\'Allemagne des années 1920.',
                'year' => 1927,
                'stock' => 2,
                'category' => 'Fiction',
                'authors' => ['Hermann Hesse']
            ],
            // Livres de Mark Manson
            [
                'title' => 'L\'art subtil de s\'en foutre',
                'summary' => 'Une approche à contre-courant pour vivre une bonne vie.',
                'year' => 2016,
                'stock' => 5,
                'category' => 'Développement Personnel',
                'authors' => ['Mark Manson']
            ],
            // Livres de Stefan Zweig
            [
                'title' => 'La Confusion des sentiments',
                'summary' => 'Nouvelle psychologique sur les troubles de l\'adolescence.',
                'year' => 1927,
                'stock' => 2,
                'category' => 'Fiction',
                'authors' => ['Stefan Zweig']
            ],
            [
                'title' => 'Le Joueur d\'échecs',
                'summary' => 'Nouvelle sur l\'obsession et la folie à travers le jeu d\'échecs.',
                'year' => 1943,
                'stock' => 3,
                'category' => 'Fiction',
                'authors' => ['Stefan Zweig']
            ],
            // Quelques classiques
            [
                'title' => '1984',
                'summary' => 'Dystopie totalitaire dans un monde surveillé.',
                'year' => 1949,
                'stock' => 4,
                'category' => 'Science-Fiction',
                'authors' => ['George Orwell']
            ],
            [
                'title' => 'Les Misérables',
                'summary' => 'Fresque sociale de la France du XIXe siècle.',
                'year' => 1862,
                'stock' => 2,
                'category' => 'Fiction',
                'authors' => ['Victor Hugo']
            ],
            [
                'title' => 'Harry Potter à l\'école des sorciers',
                'summary' => 'Un jeune sorcier découvre le monde de la magie.',
                'year' => 1997,
                'stock' => 6,
                'category' => 'Fantastique',
                'authors' => ['J.K. Rowling']
            ],
            [
                'title' => 'L\'Étranger',
                'summary' => 'Roman existentialiste sur l\'absurdité de la condition humaine.',
                'year' => 1942,
                'stock' => 3,
                'category' => 'Philosophie',
                'authors' => ['Albert Camus']
            ],
            [
                'title' => 'Sapiens',
                'summary' => 'Une brève histoire de l\'humanité depuis ses origines.',
                'year' => 2011,
                'stock' => 4,
                'category' => 'Histoire',
                'authors' => ['Yuval Noah Harari']
            ]
        ];

        foreach ($books as $bookData) {
            // Créer le livre
            $book = Book::create([
                'title' => $bookData['title'],
                'summary' => $bookData['summary'],
                'year' => $bookData['year'],
                'stock' => $bookData['stock'],
                'category_id' => Category::where('name', $bookData['category'])->first()->id,
            ]);

            // Attacher les auteurs
            foreach ($bookData['authors'] as $authorName) {
                $nameParts = explode(' ', $authorName, 2);
                $firstName = $nameParts[0];
                $lastName = $nameParts[1] ?? '';
                
                $author = Author::where('first_name', $firstName)
                    ->where('last_name', $lastName)
                    ->first();
                    
                if ($author) {
                    $book->authors()->attach($author->id);
                }
            }
        }
    }
}
