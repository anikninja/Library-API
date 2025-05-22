<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Bookshelves;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Show all books in a bookshelf.
     */
    public function index(string $bookshelfId): JsonResponse
    {
        $books = Book::where('bookshelf_id', $bookshelfId)->get();

        if ($books->isEmpty()) {
            return response()->json(['message' => 'No books found in this bookshelf'], 404);
        }

        return response()->json(['books' => $books]);
    }

    /**
     * Show a specific book in a bookshelf.
     */
    public function show(string $bookshelfId, string $id): JsonResponse
    {
        $book = $this->findBook($bookshelfId, $id);

        if (!$book) {
            return response()->json(['message' => 'Book not found in this bookshelf'], 404);
        }

        return response()->json(['book' => $book]);
    }

    /**
     * Store a newly created book in a bookshelf.
     */
    public function store(string $bookshelfId, Request $request): JsonResponse
    {
        // Validate the bookshelf ID
        $bookshelf = Bookshelves::find($bookshelfId);
        if (!$bookshelf) {
            return response()->json(['message' => 'Bookshelf not found'], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
        ]);

        $book = new Book([
            'title' => $request->title,
            'author' => $request->author,
            'published_year' => $request->published_year,
        ]);
        $book->bookshelf()->associate($bookshelf);
        $book->save();
        if (!$book) {
            return response()->json(['message' => 'Failed to create book'], 500);
        }

        return response()->json([
            'message' => 'Book created successfully',
            'book' => $book,
        ], 201);
    }

    /**
     * Update a specific book in a bookshelf.
     */
    public function edit(string $bookshelfId, string $id, Request $request): JsonResponse
    {
        if (!$book = $this->findBook($bookshelfId, $id)) {
            return response()->json(['message' => 'Book not found in this bookshelf'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'published_year' => 'sometimes|integer',
        ]);

        $book->update($validatedData);

        return response()->json([
            'message' => 'Book updated successfully',
            'book' => $book,
        ]);
    }

    /**
     * Remove a specific book from a bookshelf.
     */
    public function destroy(string $bookshelfId, string $id, Request $request): JsonResponse
    {
        $bookshelf = Bookshelves::find($bookshelfId);
        if (!$bookshelf) {
            return response()->json(['message' => 'Bookshelf not found'], 404);
        }

        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Check Integrity constraints here
        try {
            // Delete the book
            $book->delete();
        } catch (\Exception $e) {
            // Handle the exception if the book cannot be deleted due to integrity constraints
            return response()->json(['message' => 'Integrity constraint violation. Failed to delete book'], 500);
        }

        return response()->json(['message' => 'Book deleted successfully']);
    }

    /**
     * Find a book by bookshelf ID and book ID.
     */
    private function findBook(string $bookshelfId, string $id): ?Book
    {
        return Book::where('bookshelf_id', $bookshelfId)->find($id);
    }

    /**
     * Search for books by title or author.
     */
    public function searchBook(Request $request): JsonResponse
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json(['message' => 'Search query is required'], 400);
        }

        $books = Book::where('title', 'LIKE', "%{$query}%")
            ->orWhere('author', 'LIKE', "%{$query}%")
            ->get();

        if ($books->isEmpty()) {
            return response()->json(['message' => 'No books found matching the search criteria'], 404);
        }

        return response()->json(['books' => $books]);
    }
}
