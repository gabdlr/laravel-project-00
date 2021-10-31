<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
class PostsApiController extends Controller
{
    public function index()
    {
        return Post::All();
    }
    // public function index(Request $request)
    // {
    //     return Post::All();
    // }

    public function save()
    {
        request()->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
    
        return Post::create([
            'title' => request('title'),
            'content' => request('content')
        ]);
    }

    public function update(Post $post) 
    {
        request()->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
    
        $success = $post->update([
            'title' => request('title'),
            'content' => request('content')
        ]);
    
        return [
            'success' => $success
        ];
    }

    public function destroy(Post $post)
    {
        $success = $post->delete();

        return [
            "success" => $success
        ];
    }
}
