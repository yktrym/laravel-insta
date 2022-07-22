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
        $user = $this->user->findOrFail($id);
        return view('users.profile.show')->with('user',$user);
   }

   public function edit()
   {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
   }

   public function update(Request $request)
   {
        $request->validate([
            'name'         => 'required|min:1|max:50',
            'email'        => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
            'avatar'       => 'mimes:jpg,jpeg,gif,png|max:1048',
            'introduction' => 'max:50'
        ]);

        # Update the name
        $user = $this->user->findOrFail(Auth::user()->id);
        $user->name = $request->name;
        # email
        $user->email = $request->email;
        # introduction
        $user->introduction = $request->introduction;

        if ($request->avatar){
            # Delete the old
            $this->deleteAvatar($user->avatar);
            # Save the new
            $user->avatar = $this->saveAvatar($request);
        }

        # Save
        $user->save();

        # Redirect
        return redirect()->route('profile.show', Auth::user()->id);
    }

    private function deleteAvatar($avatar_name){
        $avatar_path = self::LOCAL_STORAGE_FOLDER . $avatar_name;

        if(Storage::disk('local')->exists($avatar_path)){
            Storage::disk('local')->delete($avatar_path);
        }
    }

    private function saveAvatar($request)
    {       
        $avatar_name = time() . "." .$request->avatar->extension();

        $request->avatar->storeAs(self::LOCAL_STORAGE_FOLDER, $avatar_name);

        return $avatar_name;
    }
}
# update(). Update the name, email, and introduction.
# Check if the user uploaded an avatar. If yes, go to the next step. Otherwise, skip to #5.
# Delete the old avatar from local storage. deleteAvatar()
# Save the new avatar in the local storage. saveAvatar()
# Save.
# Redirect to profile.show

# const LOCAL_STORAGE_FOLDER = 'public/avatars/';
