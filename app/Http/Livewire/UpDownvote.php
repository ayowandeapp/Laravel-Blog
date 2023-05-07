<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class UpDownvote extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post;

    }

    public function render()
    {
        $upvotes = \App\Models\UpDownvote::query()->where('post_id', $this->post->id)
                    ->where('is_upvote', true)->count();
        $downvotes = \App\Models\UpDownvote::query()->where('post_id', $this->post->id)
                    ->where('is_upvote', false)->count();
        //get user
        $user = request()->user();
        if($user) {
            $model = \App\Models\UpDownvote::query()->where(['post_id' => $this->post->id, 'user_id' => $user->id])->first();
            if($model){
                $vote = !!$model->is_upvote;
            }else{
                $vote = '';
            }
        }else{
            $vote = '';
        }
        return view('livewire.up-downvote', compact('upvotes', 'downvotes', 'vote'));
    }

    public function UpDownvote($upvote = true)
    {
        // /** @var \App\Models\User $user */
        $user = request()->user();
        if (!$user) {
            return $this->redirect('login');
        }

        if (!$user->hasVerifiedEmail()) {
            return $this->redirect(route('verification.notice'));
        }
        $model = \App\Models\UpDownvote::query()->where(['post_id' => $this->post->id, 'user_id' => $user->id])->first();

        if(!$model){
            \App\Models\UpDownvote::create([
                'is_upvote'=> $upvote,
                'post_id'=>$this->post->id,
                'user_id' => $user->id
            ]);
            return;
        }
        if ($upvote && $model->is_upvote || !$upvote && !$model->is_upvote) {
            $model->delete();
        } else {
            $model->is_upvote = $upvote;
            $model->save();
        }
    }
}
