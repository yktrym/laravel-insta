<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false;

    # To get the info of the follower
    public function user()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    # To get the info of the user you are following
    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
