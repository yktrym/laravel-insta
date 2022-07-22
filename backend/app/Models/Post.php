<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    # To get the owner of the post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    # To get all the categories of a post
    public function categoryPost()
    {
        return $this->hasMany(CategoryPost::class);
    }

    # To get all the comments of a post
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    # To get the likes of a post
    public function likes()
    {
        return $this->hasMany(Like::class);
    }


    # Returns true if the Auth user already liked the post
    public function isLiked()
    {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }
}
