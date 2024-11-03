<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Topic;

class CommentController extends Controller
{
    public function listAllComments()
    {
        $comments = Comment::all();
        $topics = Topic::all();
        return view('comments.listAllComments', compact('comments', 'topics'));
    }

    public function listCommentById($id)
    {
        $comment = Comment::findOrFail($id);
        return view('comments.listCommentById', compact('comment'));
    }

    public function createComment(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image',
        ]);

        $comment = Comment::create([
            'content' => $request->content,
        ]);

        $comment->post()->create([
            'user_id' => auth()->id(),
            'image' => $request->file('image') ? $request->file('image')->store('images', 'public') : null,
        ]);

        return redirect()->route('listAllComments')->with('success', 'Comment created successfully.');
    }

    public function updateComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->content = $request->content;
        $comment->save();

        $post = $comment->post;
        if ($post) {
            $post->update([
                'image' => $request->file('image') ? $request->file('image')->store('images', 'public') : $post->image,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('listAllComments')->with('success', 'Comment updated successfully.');
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        
        return redirect()->route('listAllComments')->with('success', 'Comment deleted successfully.');
    }
}
