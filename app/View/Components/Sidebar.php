<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Category;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
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
        return view('components.sidebar')->with(compact('categories'));
    }
}
