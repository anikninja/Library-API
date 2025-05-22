<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Bookshelves;
use App\Http\Resources\Api\BookshelvesResource;
use App\Http\Controllers\BookshelvesController;
use App\Http\Controllers\BookController;
use App\Http\Resources\Api\BookResource;
use App\Http\Controllers\ChapterController;

Route::middleware('guest')
    ->group(function () {
        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware('guest')
            ->name('register');

        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('guest')
            ->name('login');
    });

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        Route::get('/user', function (Request $request) {
            return response()->json([
                'user' => $request->user(),
            ]);
        });


        // Bookshelves routes
        // Get a specific bookshelf
        Route::get('/bookshelves/{id}', function (string $id) {
            return new BookshelvesResource(Bookshelves::findOrFail($id));
        });

        // Get all bookshelves
        Route::get('/bookshelves', function () {
            return BookshelvesResource::collection(Bookshelves::all());
        });

        //Create a new bookshelf
        Route::post('/bookshelves/create', [BookshelvesController::class, 'store'])
            ->name('bookshelves.store');

        // Update an existing bookshelf
        Route::put('/bookshelves/edit/{id}', [BookshelvesController::class, 'edit'])
            ->name('bookshelves.edit');

        // Delete a bookshelf
        Route::delete('/bookshelves/delete/{id}', [BookshelvesController::class, 'destroy'])
            ->name('bookshelves.destroy');


        
        // Books Routes
        // Get all books in a bookshelf
        Route::get('/bookshelves/{id}/books', [BookController::class, 'index'])
        ->name('books.index');
        
        // Get a specific book
        Route::get('/bookshelves/book/{id1}/{id2}', [BookController::class, 'show'])
            ->name('book.show');

        // Create a new book
        Route::post('/bookshelves/book/create/{id}', [BookController::class, 'store'])
            ->name('book.store');
        // Update an existing book
        Route::put('/bookshelves/book/edit/{id1}/{id2}', [BookController::class, 'edit'])
            ->name('book.edit');
        // Delete a book
        Route::delete('/bookshelves/book/delete/{id1}/{id2}', [BookController::class, 'destroy'])
            ->name('book.destroy');


        // Chapter routes
        // Get all chapters in a book
        Route::get('/book/chapter/{id}', [ChapterController::class, 'index'])
            ->name('chapter.index');

        // Get a specific chapter
        Route::get('/book/chapter/{id1}/{id2}', [ChapterController::class, 'show'])
            ->name('chapter.show');

        // Create a new chapter
        Route::post('/book/chapter/create/{id}', [ChapterController::class, 'store'])
            ->name('chapter.store');

        // Update an existing chapter
        Route::put('/book/chapter/edit/{id1}/{id2}', [ChapterController::class, 'update'])
            ->name('chapter.edit');

        // Delete a chapter
        Route::delete('/book/chapter/delete/{id1}/{id2}', [ChapterController::class, 'destroy'])
            ->name('chapter.destroy');

    });
