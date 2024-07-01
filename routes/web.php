<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\SubscriptionsController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    Route::resource('posts', PostController::class);
    Route::get('posts.pending', [PostController::class, 'pending'])->name('posts.pending');
    Route::get('posts.user_posts', [PostController::class, 'user_posts'])->name('posts.user.posts');
    Route::post('posts./{post}/approve', [PostController::class, 'approve'])->name('posts.approve');
    Route::post('posts./{post}/reject', [PostController::class, 'reject'])->name('posts.reject');
    Route::resource('posts.comments', CommentController::class);
    Route::post('posts/{post}/like', [PostLikeController::class, 'like'])->name('posts.like');
    Route::post('posts/{post}/unlike', [PostLikeController::class, 'unlike'])->name('posts.unlike');
    Route::get('posts.search', [PostController::class, 'search'])->name('posts.search');
    Route::get('posts/sortByViews', [PostController::class, 'sortByViews'])->name('posts.sortByViews');
    Route::resource('subscriptions', SubscriptionsController::class);
});

require __DIR__ . '/auth.php';
