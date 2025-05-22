<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\chapter;

class PageController extends Controller
{
    public function index(string $chapterId, Request $request): JsonResponse
    {
        $chapter = Chapter::find($chapterId);
        if (!$chapter) {
            return response()->json(['message' => 'Chapter not found'], 404);
        }

        $pages = Page::where('chapter_id', $chapterId)->get();

        if ($pages->isEmpty()) {
            return response()->json(['message' => 'No pages found in this chapter'], 404);
        }

        return response()->json(['pages' => $pages]);
    }

    /**
     * Show a specific chapter in a bookshelf.
     */
    public function show(string $chapterId, string $id): JsonResponse
    {
        $page = $this->findPage($chapterId, $id);

        if (!$page) {
            return response()->json(['message' => 'Page not found in this chapter'], 404);
        }

        return response()->json(['page' => $page]);
    }

    /**
     * Store a newly created chapter in a bookshelf.
     */
    public function store(string $chapterId, Request $request): JsonResponse
    {
        $chapter = Chapter::find($chapterId);
        if (!$chapter) {
            return response()->json(['message' => 'Chapter not found'], 404);
        }

        $validatedData = $request->validate([
            'page_number' => 'required|integer',
            'content' => 'required|string',
        ]);

        $page = new Page($validatedData);
        $chapter->pages()->saveMany([$page]);

        return response()->json([
            'message' => 'Page created successfully',
            'page' => $page,
        ], 201);
    }

    /**
     * Update a specific chapter in a bookshelf.
     */
    public function update(string $chapterId, string $id, Request $request): JsonResponse
    {
        $page = $this->findPage($chapterId, $id);

        if (!$page) {
            return response()->json(['message' => 'Page not found in this chapter'], 404);
        }

        $validatedData = $request->validate([
            'page_number' => 'sometimes|required|integer',
            'content' => 'sometimes|required|string',
        ]);

        $page->update($validatedData);

        return response()->json([
            'message' => 'Page updated successfully',
            'page' => $page,
        ]);
    }

    /**
     * Remove a specific chapter from a bookshelf.
     */
    public function destroy(string $chapterId, string $id): JsonResponse
    {
        $page = $this->findPage($chapterId, $id);

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        try {
            $page->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete page due to integrity constraints'], 500);
        }

        return response()->json(['message' => 'Page deleted successfully']);
    }

    /**
     * Find a page by chapter ID and page ID.
     */
    private function findPage(string $chapterId, string $id): ?Page
    {
        return Page::where('chapter_id', $chapterId)->find($id);
    }
}
