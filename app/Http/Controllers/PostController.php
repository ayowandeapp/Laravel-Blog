<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\PostView;
use DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::query()
        //     ->where('active', 1)
        //     ->whereDate('published_at', '<', Carbon::now())
        //     ->orderBy('published_at', 'desc')
        //     ->paginate(5);

        $latestPost = Post::query()->where('active', 1)
            ->whereDate('published_at', '<', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();
        $popularPost = Post::query()
            ->leftJoin('up_downvotes', 'posts.id', '=', 'up_downvotes.post_id')
            ->select('posts.*', \DB::raw('COUNT(up_downvotes.id) as upvote_count'))
            ->where(function($query){
                $query->where('up_downvotes.is_upvote', '=', 1)
                    ->orWhereNull('up_downvotes.is_upvote');
                })
            ->where('active', 1)
            ->whereDate('published_at', '<', Carbon::now())
            ->orderBy('upvote_count', 'desc')
            ->groupBy('posts.id')
            ->limit(3)
            ->get();

            $user = request()->user();
            if($user){
                $leftJoin = "(SELECT cp.category_id, cp.post_id FROM up_downvotes JOIN category_post as cp ON up_downvotes.post_id = cp.post_id WHERE up_downvotes.is_upvote = 1 and up_downvotes.user_id = ?) as t";
                $recommendedPost = Post::query()
                    ->leftJoin('category_post  as cp', 'posts.id', 'cp.post_id')
                    ->leftJoin(DB::raw($leftJoin), function($join){
                        $join->on('t.category_id', '=', 'cp.category_id')
                            ->on('t.post_id', '<>', 'cp.post_id');
                    })
                    ->select('posts.*')
                    // ->where('posts.id', '<>', DB::raw('t.post_id'))
                    ->setBindings([$user->id])
                    ->limit(3)
                    ->get();

            }else{
                $recommendedPost = Post::query()
                    ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
                    ->select('posts.*', \DB::raw('COUNT(post_views.id) as post_views'))
                    ->where('active', 1)
                    ->whereDate('published_at', '<', Carbon::now())
                    ->orderBy('post_views', 'desc')
                    ->groupBy('posts.id')
                    ->limit(3)
                    ->get();
            }

            $recentCategories = Category::query()
                ->select('categories.*')
                ->leftJoin('category_post', 'categories.id', '=', 'category_post.category_id')
                ->leftJoin('posts', 'posts.id', '=', 'category_post.post_id')
                ->selectRaw('Max(posts.published_at) as max_date')
                ->orderByDesc('max_date')
                ->groupBy('categories.id')
                ->whereHas('posts', function($query){
                    $query->where('active', 1)
                        ->whereDate('published_at', '<', Carbon::now());
                })
                ->limit(5)
                ->get();

        return view('home')->with(compact('latestPost', 'recentCategories','popularPost', 'recommendedPost'));
    }

    public function byCategory(Category $category)
    {
        $posts = Post::query()
        ->join('category_post', 'posts.id', '=', 'category_post.post_id')
            ->where('active', 1)
            ->whereDate('published_at', '<', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        return view('index')->with(compact('posts'));


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
