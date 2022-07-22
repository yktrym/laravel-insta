<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
    }

    public function store($id)
    {
        $this->follow->follower_id  = Auth::user()->id;
        $this->follow->following_id = $id;
        $this->follow->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->follow
            ->where('following_id', $id)
            ->where('follower_id', Auth::user()->id)
            ->delete();
        return redirect()->back();
    }
}
