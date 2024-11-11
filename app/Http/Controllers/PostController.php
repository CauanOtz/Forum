<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function listAllPosts()
    {
        $posts = Post::all(); 
        return view('posts.listAllPosts', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description; 
        $post->save();

        return response()->json(['success' => 'Post created successfully']);
    }

    public function editPost($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.editPost', compact('post'));
    }

    public function updatePost(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return response()->json(['success' => 'Post updated successfully']);
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['success' => 'Post deleted successfully']);
    }
}
