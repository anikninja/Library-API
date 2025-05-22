<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    /** @use HasFactory<\Database\Factories\ChapterFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'chapter_number',
        'book_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

}
