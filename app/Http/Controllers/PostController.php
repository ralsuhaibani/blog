<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //TODO MERGE SEARCH AND VIEWS HERE
    {
        return view('posts.index', [
            'posts' =>  Post::approved()->latest()->paginate(10),
            'twoDaysFromNow' => Carbon::now()->addDays(2),
        ]);
    }

    public function sortByViews()
    {
        return view('posts.index', [
            'posts' => Post::mostViewed()->paginate(10),

        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $posts = Post::where(function ($query) use ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('body', 'LIKE', '%' . $search . '%')
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                })
                ->orWhereHas('comments', function ($query) use ($search) {
                    $query->where('body', 'LIKE', '%' . $search . '%');
                });
        })->latest()
            ->paginate(10);

        return view('posts.index', [
            'posts' =>  $posts,
            'search' =>  $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->subscription->plan->name === 'basic' && auth()->user()->posts->count() >= 5) {
            return back()->with('message', 'you paln is basic cant create more than 5 posts');
        }
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',

        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public/images');
        }
        $request->user()->posts()->create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'image' => $image ?? null,
        ]);

        return redirect()->route('posts.index')->with('message', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->increment('count');

        return view('posts.show', [
            'post' => $post,
            'comments' => $post->comments()->with('user')->paginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return view('posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);
        $data = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        $post->title = $data['title'];
        $post->body = $data['body'];
        $post->save();

        return redirect()->route('posts.index')->with('message', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // $this->authorize('delete', $post);
        if (auth()->user()->id === $post->user_id) {

            $post->delete();

            return back();
        }
    }
    public function pending()
    {
        Gate::authorize('pending', Post::class);
        $post = new Post();
        $pendings = $post->pending()->get();

        return view('posts.pending', [
            'pendings' => $pendings
        ]);
    }

    public function approve(Post $post)
    {

        Gate::authorize('approve', Post::class);
        if ($post->status !== Post::PENDING) {
            return redirect()->route('posts.pending')
                ->with('error', 'only pending requests can be approved or rejected');
        }

        $post->update(['status' =>  Post::APPROVED]);
        return redirect()->route('posts.pending')
            ->with('message', 'post has been approved successfully');
    }

    public function reject(Request $request, Post $post)
    {
        Gate::authorize('reject', Post::class);
        if ($post->status !== Post::PENDING) {
            return redirect()->route('posts.pending')
                ->with('error', 'only pending requests can be approved or rejected');
        }

        $post->update([

            'status' =>  Post::REJECTED,
            'note' => $request->input('note')
        ]);
        return redirect()->route('posts.pending')
            ->with('message', 'post has been rejected successfully');
    }

    public function user_posts(Request $request)
    {
        return view('posts.user_posts', [
            'posts' =>  Post::where('user_id', $request->user()->id)->latest()->paginate(10),
        ]);
    }
}
