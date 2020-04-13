<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfilesController extends Controller
{
    //
    public function index(User $user)
    {
        return view('profiles/index', [
            'user'=> $user,
        ]);
    }

    public function edit(User $user){
        $this->authorize('update',$user->profile);

        return view('profiles/edit',[
            'user'=>$user,
        ]);



    }


    public function update(User $user){
        $this->authorize('update',$user->profile);

        $data = request()->validate([
            'about'=> 'required',
            'interests'=>'required',
        ]);

        auth()->user()->profile->update($data);

        return redirect("/profile/{$user->id}");
    }
}
