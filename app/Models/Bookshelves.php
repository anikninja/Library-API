<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookshelves extends Model
{
    /** @use HasFactory<\Database\Factories\BookshelvesFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    
}
