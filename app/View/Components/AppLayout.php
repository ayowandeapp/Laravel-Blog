<?php

namespace App\View\Components;

use Illuminate\View\View;
use Closure;
use Illuminate\View\Component;
use App\Models\Category;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    // public function render(): View
    // {
    //     return view('layouts.app');
    // }
    public function __construct(public ?string $metaTitle= null, public ?string $metaDescription=null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = Category::query()
            ->join('category_post', 'categories.id', '=', 'category_post.category_id')
            ->select('categories.title', 'categories.slug', \DB::raw('count(*) as total'))
            ->groupBy('categories.id')
            ->orderByDesc('total')
            ->get();
        return view('layouts.app')->with(compact('categories'));
    }
}
