<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:255']
        ]);

        $post->comments()->create([
            ...$data,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('posts.show', $post);
    }

    public function edit(Post $post, Comment $comment)
    {
        Gate::authorize('update', $comment);
            return view('posts.comments.edit', [
                'post' => $post,
                'comment' => $comment
            ]);   
        
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        Gate::authorize('update', $comment);
        $data = $request->validate([
            'body' => 'required',
        ]);
        $comment->body = $data['body'];
        $comment->save();

        return redirect()->route('posts.index')->with('message', 'comment updated successfully');
    }

}
