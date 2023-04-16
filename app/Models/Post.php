<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'body', 'active', 'published_at', 'thumbnail', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
