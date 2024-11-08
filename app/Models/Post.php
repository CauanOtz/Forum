<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function averageRating(){
        return $this->rates()->avg('vote');
    }

    public function upVotesCount(){
        return $this->rates()->where('vote', 1)->count();
    }

    public function downVotesCount(){
        return $this->rates()->where('vote', -1)->count();
    }

    public function postable(){
        return $this->morphTo();
    }


}
