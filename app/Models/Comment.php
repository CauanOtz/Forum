<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Post
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'topic_id'
    ];

    public function post()
    {
        return $this->morphOne(Post::class, 'postable');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    
        public function replies()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('commentable_type', Comment::class);
    }
}