<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


class PostController extends Controller
{

    public function index(Post $post)
    {

        // getting all posts
        $posts = Post::all();


        // returning the view with the posts data
        return view('admin.posts.index',['posts'=> $posts]);
    }

    public function show(Post $post)
    {

        return view('blog-post', ['post'=> $post]);
    }

    public function create()
    {

        return view('admin.posts.create');
    }

    public function store(){

        $inputs = request()->validate([
            'title' => 'required|min:8|max:255',
            'post_image'=>'file',
            'body' => 'required'
        ]);

        if(request('post_image')){
           $inputs['post_image'] = request('post_image')->store('images');
        }

        auth()->user()->post()->create($inputs);
        session()->flash('post-created-message', 'Post name '.$inputs['title'].' was created');

        return redirect()->route('posts.index');
    }

//    public function setPostImageAttribute($value) {
//        $this->attribute['post_image']= asset($value);
//    }

    public function setPostImageAttribute($value) {
        return asset($value);
    }

    public function delete(Post $post,Request $request) {
        $post->delete();

        $request->session()->flash('message', 'Post name '.$post['title'].' was deleted');

        return back();
    }

    public function update(Post $post){

        $inputs = request()->validate([
            'title'=> 'required|min:8|max:255',
            'post_image'=> 'file',
            'body'=> 'required'
        ]);


        if(request('post_image')){
            $inputs['post_image'] = request('post_image')->store('images');
            $post->post_image = $inputs['post_image'];
        }

        $post->title = $inputs['title'];
        $post->body = $inputs['body'];


        $this->authorize('update', $post);


        $post->save();

        session()->flash('post-updated-message', 'Post name '.$post['title'].' was updated');

        return redirect()->route('post.index');

    }

}



