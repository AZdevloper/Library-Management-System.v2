<?php

namespace App\Models;

use App\Models\User;
use App\Models\Status;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'collection',
        'image',
        'isbn',
        'pagesNumber',
        'emplacement',
        'user_id',
        'category_id',
        'status_id',
        
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
