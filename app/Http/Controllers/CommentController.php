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

        $validatedData = $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|integer|exists:posts,id',
            'commentable_id' => 'nullable|integer|exists:comments,id',
            'topic_id' => 'required|exists:topics,id',
        ]);
        
        

        $comment = new Comment();
        $comment->content = $validatedData['content'];
        $comment->user_id = auth()->id();
        $comment->topic_id = $validatedData['topic_id'];
        
        if (!empty($validatedData['commentable_id'])) {
            $comment->commentable_id = $validatedData['commentable_id'];
            $comment->commentable_type = Comment::class;
        } else {
            $comment->commentable_id = $validatedData['post_id'];
            $comment->commentable_type = Post::class;
        }
        

        $comment->save();
    
        return redirect()->back()->with('success', 'Comentário adicionado com sucesso.');
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
