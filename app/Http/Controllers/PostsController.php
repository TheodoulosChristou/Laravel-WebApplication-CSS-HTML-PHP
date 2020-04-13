<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Post;

class PostsController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        return view('posts/create');
    }

    public function store(){
        $data = request()->validate([
            'post_title'=>'required',
            'image'=>['required','image'],
        ]);

        $path = request('image')->store('uploads','public');

        $image = Image::make(public_path("storage/{$path}"))->fit(1000,1000);
        $image->save();
        auth()->user()->posts()->create([
            'post_title' => $data['post_title'],
            'image' =>$path,
        ]);
        return redirect('/profile/'. auth()->user()->id);
    }


    public function show(Post $post){
        return view('posts/show',[
            'post'=>$post,
        ]);
    }
}
