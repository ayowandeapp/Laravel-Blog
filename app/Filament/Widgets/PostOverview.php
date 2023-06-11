<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\PostView;
use App\Models\UpDownvote;
use Illuminate\Database\Eloquent\Model;

class PostOverview extends Widget
{

    protected int | string | array $columnSpan = 3;

    public ?Model $record = null;

    protected function getViewData(): array
    {
        return [
            'viewCount'=> PostView::where('post_id', $this->record->id)->count(), 
            'upvotes' =>UpDownvote::where('post_id', $this->record->id)->where('is_upvote', 1)->count(),
            'downvotes' =>UpDownvote::where('post_id', $this->record->id)->where('is_upvote', 0)->count(),
        ];
    }

    protected static string $view = 'filament.widgets.post-overview';
}
