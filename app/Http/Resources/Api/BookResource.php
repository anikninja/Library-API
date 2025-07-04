<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'bookshelf_id' => $this->bookshelf_id,
            'title' => $this->title,
            'author' => $this->author,
            'published_year' => $this->published_year,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}