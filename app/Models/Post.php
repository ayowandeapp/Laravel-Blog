<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'body', 'active', 'published_at', 'thumbnail', 'user_id', 'meta_title', 'meta_description'];

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

    public function shortBody($words=30): string 
    {
        return \Str::words(strip_tags($this->body), $words);

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

    public function humanReadTime() :Attribute 
    {
        return Attribute::make(
            get: function(mixed $value, $attributes){
                $words = \Str::wordCount(strip_tags($attributes['body']));
                $minutes = ceil($words/200);
                return $minutes. ' '.str('min')->plural($minutes). ', '
                    .$words. ' '.str('word')->plural($words);

            });

    }
    //  <section class="w-full md:w-2/3 flex flex-col items-center px-3">

    //     @foreach($posts as $post)
    //         <x-post-item :post='$post'></x-post-item>
    //     @endforeach 
    //     {{$posts->links()}}

    // </section>

    // <x-sidebar /> 


}
