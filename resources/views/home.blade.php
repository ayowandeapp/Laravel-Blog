<x-app-layout >
    
    <div class="container mx-auto py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- latest post -->
            <div class="col-span-2">
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase border-b-2 border-blue-500 mb-3 pb-1">Latest Post</h2>
                <x-post-item :post='$latestPost'></x-post-item>
                
            </div>

            <!-- popular post -->
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase border-b-2 border-blue-500 mb-3 pb-1">Popular Post</h2>
                @foreach($popularPost as $post)
                 <div class="grid grid-cols-4 gap-2">
                    <a href="{{ route('view', $post) }}">
                        <img src="{{$post->getThumbnail()}}" alt="{{$post->title}}">
                    </a>
                    <div class="col-span-3">
                        <a href="{{ route('view', $post) }}">
                            <h3 class="uppercase truncate">{{$post->title}}</h3>
                        </a>
                        @if(count($post->categories) > 0)
                        <div class="flex gap-4">
                            @foreach($post->categories as $category)
                                <a href="{{ route('by-category',$category) }}" class="bg-blue-500 text-xs font-bold uppercase text-white rounded p-1">{{$category->title}}</a>
                            @endforeach
                        </div>
                        @endif
                        <div class="text-sm">
                            {{$post->shortBody(10)}}
                        </div>
                    </div>

                 </div>
                @endforeach 
            </div>
        </div>

        <div>
            <!-- recommended post -->
            <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase border-b-2 border-blue-500 mb-3 pb-1">Recommended Post</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach($recommendedPost as $post)
                    <x-post-item :post='$post' :show-author="false"></x-post-item>
                @endforeach
            </div>
        </div>
        <div>
            <!-- Latest categories -->
            <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase border-b-2 border-blue-500 mb-3 pb-1">Latest Categories</h2>
            @foreach($recentCategories as $cat)
                <p class="text-xs text-blue-500 uppercase border-blue-500 mb-4 pb-1"><a href="{{ route('by-category',$category) }}">{{$cat->title}}<i class="fa fa-arrow -right"></i></a></p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @foreach($cat->publishedPosts()->limit(3)->get() as $post)
                        <x-post-item :post='$post' :show-author="false"></x-post-item>
                    @endforeach
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>