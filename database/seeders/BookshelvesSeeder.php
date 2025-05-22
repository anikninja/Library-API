<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bookshelves;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Page;

class BookshelvesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bookshelves::factory()->count(2)->create()->each(function ($bookshelf) {
            $books = Book::factory()->count(2)->create(['bookshelf_id' => $bookshelf->id]);
            $books->each(function ($book) {
                $chapters = Chapter::factory()->count(2)->create(['book_id' => $book->id]);
                $chapters->each(function ($chapter) {
                    Page::factory()->count(2)->create(['chapter_id' => $chapter->id]);
                });
            });
        });
    }
}
