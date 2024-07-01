<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => PostStatus::class,
    ];

    protected $fillable = ['title', 'image', 'body', 'status', 'note'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function likes()
    {
        return $this->belongsToMany(User::class, 'like_post');
    }

    public function scopePending()
    {
        return $this->where('status',PostStatus::PENDING);
    }
    
    public function scopeApproved()
    {
        return $this->where('status',PostStatus::APPROVED);
    }

    public function scopeRejected()
    {
        return $this->where('status',PostStatus::REJECTED);
    }

    public function scopeMostViewed()
    {
        return $this->approved()->orderBy('count', 'DESC');
    }
}
