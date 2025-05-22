<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /** @use HasFactory<\Database\Factories\PageFactory> */
    use HasFactory;

    protected $fillable = [
        'page_number',
        'content',
        'chapter_id',
    ];
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
