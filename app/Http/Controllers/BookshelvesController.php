<?php

namespace App\Http\Controllers;

use App\Models\Bookshelves;
use App\Http\Requests\StoreBookshelvesRequest;
use App\Http\Requests\UpdateBookshelvesRequest;
use App\Http\Resources\Api\BookshelvesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class BookshelvesController extends Controller
{
    // Store a new bookshelf
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $bookshelf = Bookshelves::create([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        if (!$bookshelf) {
            return response()->json(['message' => 'Failed to create bookshelf'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Bookshelf created successfully',
            'bookshelf' => new BookshelvesResource($bookshelf),
        ], Response::HTTP_CREATED);
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request): JsonResponse
    {
        $bookshelf = Bookshelves::findOrFail($id);
        if (!$bookshelf) {
            return response()->json([
                'message' => 'Bookshelf not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $bookshelf->update([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        if (!$bookshelf) {
            return response()->json(['message' => 'Failed to update bookshelf'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Bookshelf updated successfully',
            'bookshelf' => new BookshelvesResource($bookshelf),
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request): JsonResponse
    {
        $bookshelves = Bookshelves::findOrFail($id);
        if (!$bookshelves) {
            return response()->json([
                'message' => 'Bookshelf not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Implement the logic to delete a bookshelf
        $bookshelves->delete();

        return response()->json([
            'message' => 'Bookshelf deleted successfully',
        ], Response::HTTP_OK);
    }
}
