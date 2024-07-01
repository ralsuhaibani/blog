<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Notifications\PostLikedNotification;


class PostLikeController extends Controller
{
    public function like(Request $request, Post $post)
    {
        if ($post->user->id === $request->user()->id) {
            return redirect()->route('posts.show', $post)->with('error', 'you are  not allowed to like your posts');
        }

        auth()->user()->likes()->attach($post);

        $post->user->notify(new PostLikedNotification($post));

        return redirect()->route('posts.show', $post)->with('message', 'Liked successfully');
    }
    public function unlike(Post $post)
    {
        auth()->user()->likes()->detach($post);

        return redirect()->route('posts.show', $post)->with('message', 'Liked successfully');
    }
}
