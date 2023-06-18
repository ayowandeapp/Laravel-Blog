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
                    <div>
                        <img src="{{$post->getThumbnail()}}" alt="{{$post->title}}">
                    </div>
                    <div class="col-span-3">
                        <h3 class="uppercase truncate">{{$post->title}}</h3>
                        @if(count($post->categories) > 0)
                        <div class="flex gap-4">
                            @foreach($post->categories as $category)
                                <a href="#" class="bg-blue-500 text-xs font-bold uppercase text-white rounded p-1">{{$category->title}}</a>
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
        </div>
        <div>
            <!-- Latest categories -->
            <h2 class="text-lg sm:text-xl font-bold text-blue-500 uppercase border-b-2 border-blue-500 mb-3 pb-1">Latest Categories</h2>
        </div>

    </div>
</x-app-layout>