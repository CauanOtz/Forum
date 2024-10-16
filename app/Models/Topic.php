<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status'
    ];
           
    public function post(){
        return $this->belongsTo(Post::class);
    }
    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }
}
