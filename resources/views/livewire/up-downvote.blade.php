<div class="flex gap-2">
    <br />
    <button wire:click="UpDownvote(true)" class="flex item-center gap-2 hover:text-blue-500 transition-all {{ $vote ? 'text-blue-600' : '' }}">Up {{ $upvotes }}</button>
    <button wire:click="UpDownvote(false)" class="flex item-center gap-2 hover:text-blue-500 transition-all {{ $vote === false ? 'text-blue-600' : '' }}">Down {{ $downvotes }}</button>
</div>
