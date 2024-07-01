<?php

namespace App\Observers;

use App\Models\Post;
use App\Notifications\PostViewedNotification;
use App\Notifications\PostApprovedNotification;
use App\Notifications\PostRejectedNotification;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        if ($post->isDirty('status') && $post->status === 'APPROVED') {
            $post->user->notify(new PostApprovedNotification($post));
        } else {
            $post->user->notify(new PostRejectedNotification($post));
        }
        if ($post->isDirty('count') && $post->count == 10) {
            $post->user->notify(new PostViewedNotification($post));
        }
    }
    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
