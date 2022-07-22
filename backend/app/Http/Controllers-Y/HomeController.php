<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $post;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_posts       = $this->post->latest()->get();
        $suggested_users = $this->getSuggestedUsers();
        return view('users.home')->with('all_posts', $all_posts)->with('suggested_users', $suggested_users);
    }

    private function gesSuggestedUsers()
    {
        $all_users = $this->user->ALL()->except(Auth::user()->id);
        $suggested_users = [];

        foreach ($all_users as $user){
            if(!$user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }

        return $suggested_users;
    }
}
