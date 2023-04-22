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

    protected $casts = [
        'published_at'=> 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function shortBody(): string 
    {
        return \Str::words(strip_tags($this->body), 30);

    }

    public function formatedDate()
    {
        return $this->published_at->format('F jS Y');
    }
    public function getThumbnail()
    {
        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }
        return '/storage/'. $this->thumbnail;
    }
}
