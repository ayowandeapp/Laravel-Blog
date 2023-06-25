<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug'];

    public function posts()
    {
        return $this->BelongsToMany(Post::class);
    }

    public function publishedPosts()
    {
        return $this->BelongsToMany(Post::class)->where('active', 1)
            ->whereDate('published_at', '<', Carbon::now());
    }
}
