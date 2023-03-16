<?php

namespace App\Http\Resources;

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
            'id'=> $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'collection' => $this->collection,
            'image' => $this->image,
            'pagesNumber' => $this->pagesNumber,
            'emplacement' => $this->emplacement,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'status_id' => $this->status_id,
            'updated_at' => $this->updated_at,
        ];
    }
}
