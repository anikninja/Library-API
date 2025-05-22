<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Bookshelf;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Book;

class ChapterController extends Controller
{
    /**
     * Show all chapters in a bookshelf.
     */
    public function index(string $bookId, Request $request): JsonResponse
    {
        $book = Book::find($bookId);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $chapters = Chapter::where('book_id', $bookId)->get();

        if ($chapters->isEmpty()) {
            return response()->json(['message' => 'No chapters found in this book'], 404);
        }

        return response()->json(['chapters' => $chapters]);
    }

    /**
     * Show a specific chapter in a bookshelf.
     */
    public function show(string $bookId, string $id): JsonResponse
    {
        $chapter = $this->findChapter($bookId, $id);

        if (!$chapter) {
            return response()->json(['message' => 'Chapter not found in this book'], 404);
        }

        return response()->json(['chapter' => $chapter]);
    }

    /**
     * Store a newly created chapter in a bookshelf.
     */
    public function store(string $bookId, Request $request): JsonResponse
    {
        $book = Book::find($bookId);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'chapter_number' => 'required|integer',
        ]);

        $chapter = new Chapter($validatedData);
        $chapter->book()->associate($book);
        $chapter->save();

        return response()->json([
            'message' => 'Chapter created successfully',
            'chapter' => $chapter,
        ], 201);
    }

    /**
     * Update a specific chapter in a bookshelf.
     */
    public function update(string $bookId, string $id, Request $request): JsonResponse
    {
        $chapter = $this->findChapter($bookId, $id);

        if (!$chapter) {
            return response()->json(['message' => 'Chapter not found in this bookshelf'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'chapter_number' => 'sometimes|required|integer',
        ]);

        $chapter->update($validatedData);

        return response()->json([
            'message' => 'Chapter updated successfully',
            'chapter' => $chapter,
        ]);
    }

    /**
     * Remove a specific chapter from a bookshelf.
     */
    public function destroy(string $bookId, string $id): JsonResponse
    {
        $chapter = $this->findChapter($bookId, $id);

        if (!$chapter) {
            return response()->json(['message' => 'Chapter not found'], 404);
        }

        try {
            $chapter->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete chapter due to integrity constraints'], 500);
        }

        return response()->json(['message' => 'Chapter deleted successfully']);
    }

    /**
     * Find a chapter by bookshelf ID and chapter ID.
     */
    private function findChapter(string $bookId, string $id): ?Chapter
    {
        return Chapter::where('book_id', $bookId)->find($id);
    }
}
