<x-filament::widget class="grid grid-cols-3 gap-3">
    <x-filament::card>
        <h2 class="text-lg sm:text-xl font-bold tracking-tight">Views
        </h2>
        <div class="flex gap-2">
            {{$viewCount}}
        </div>
    </x-filament::card>    

    <x-filament::card>
        <h2 class="text-lg sm:text-xl font-bold tracking-tight">Upvotes
        </h2>
        <div class="flex gap-2">
            {{$upvotes}}
        </div>
    </x-filament::card>

    <x-filament::card>
        <h2 class="text-lg sm:text-xl font-bold tracking-tight">Upvotes
        </h2>
        <div class="flex gap-2">
            {{$downvotes}}
        </div>
    </x-filament::card>
</x-filament::widget>
