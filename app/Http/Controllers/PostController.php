<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\PostView;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', '<', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(5);
        return view('home')->with(compact('posts'));
    }

    public function byCategory(Category $category)
    {
        $posts = Post::query()
        ->join('category_post', 'posts.id', '=', 'category_post.post_id')
            ->where('active', 1)
            ->whereDate('published_at', '<', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        return view('home')->with(compact('posts'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Request $request)
    {
        if(!$post->active || $post->published_at > Carbon::now()) {
            // throw new NotFoundHttpException();
            return redirect('/');

        }
        $next = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', '<', Carbon::now())
            ->whereDate('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->limit(1)
            ->first();
            // dd($next);
        $prev = Post::query()
            ->where('active', 1)
            ->whereDate('published_at', '<', Carbon::now())
            ->whereDate('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();


        $user  = $request->user();
        if(!$check = PostView::where(['user_id'=>$user?->id, 'post_id'=>$post->id])->first()){
            // check for ip address and user agent hre before saving
            PostView::create([
                'ip_address'=> $request->ip(),
                'user_agent'=> $request->userAgent(),
                'post_id'=> $post->id,
                'user_id' =>$user?->id
            ]);

        }
        return view('post.view')->with(compact('post', 'next', 'prev'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
