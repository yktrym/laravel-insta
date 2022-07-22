<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    private $user;
    const LOCAL_STORAGE_FOLDER = 'public/avatars/';

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        $user       = $this->user->findOrFail($id);
        // $all_posts  = $user->posts->orderBy('created_at');
        // return $all_posts;
        return view('users.profile.show')->with('user', $user);
    }

    public function edit()
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'          => 'required|min:1|max:50',
            'email'         => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
            'avatar'        => 'mimes:jpg,jpeg,gif,png|max:1048',
            'introduction'  => 'max:100'
        ]);

        $user               = $this->user->findOrFail(Auth::user()->id);
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->introduction = $request->introduction;

        if ($request->avatar){
            # Delete the old avatar
            if ($user->avatar){
                $this->deleteAvatar($user->avatar);
            }
            
            //  Save the new avatar in the local storage.
            $user->avatar = $this->saveAvatar($request);
        }

        # Save
        $user->save();

        # Redirect
        return redirect()->route('profile.show', Auth::user()->id);
    }

    private function deleteAvatar($avatar_name)
    {
        $avatar_path = self::LOCAL_STORAGE_FOLDER . $avatar_name;
        // $avatar_path = "public/avatars/1682946626.jpeg";

        if (Storage::disk('local')->exists($avatar_path)){
            Storage::disk('local')->delete($avatar_path);
        }
    }

    private function saveAvatar($request)
    {
        # Rename the image to the CURRENT TIME to avoid overwriting
        $avatar_name = time() . "." . $request->avatar->extension();
        // $avatar_name = '16823621234.jpeg';

        # Save the image inside storage/app/public/avatars/
        $request->avatar->storeAs(self::LOCAL_STORAGE_FOLDER, $avatar_name);

        return $avatar_name;
    }

    public function followers($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.profile.followers')->with('user', $user);
    }

    public function following($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.profile.following')->with('user', $user);
    }
}
