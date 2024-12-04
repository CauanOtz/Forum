<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TopicController extends Controller
{
    public function listAllTopics()
    {
        $topics = Topic::all();
        $categories = Category::all();
        $tags = Tag::all();

        return view('topics.listAllTopics', compact('topics', 'categories', 'tags'));
    }

    public function listTopicById($id)
    {
        $topic = Topic::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        $suggestedUsers = User::inRandomOrder()->take(5)->get();

        return view('topics.listTopicById', compact('topic', 'categories', 'tags', 'suggestedUsers'));
    }

    public function showTopics(Request $request)
    {
        $filter = $request->input('filter');

        $query = Topic::with([
            'post.user', 
            'post.rates', 
            'comments.comments', 
            'category'
        ])->withCount([
            'comments as comments_count', 
            'post as views_count',
        ]);
    
        $query->with(['post' => function ($query) {
            $query->withCount([
                'rates as likes_count' => function ($query) {
                    $query->where('vote', 1);
                },
                'rates as dislikes_count' => function ($query) {
                    $query->where('vote', 0);
                },
            ])->with('rates');
        }]);
    
        if ($filter === 'new') {

            $query->orderBy('created_at', 'desc');
        } elseif ($filter === 'trending') {

            $query->select('topics.*')
                ->join('posts', 'posts.postable_id', '=', 'topics.id')
                ->where('posts.postable_type', Topic::class)
                ->orderByDesc('posts.votes_count'); 
        }

        $topics = $query->take(10)->get();

        $categories = Category::all();
        $suggestedUsers = User::inRandomOrder()->take(5)->get();
        $tags = Tag::all();
    
        return view('welcome', compact('topics', 'categories', 'suggestedUsers', 'tags'));
    }

    public function createTopic(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|url',
            'status' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $topic = Topic::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        $topic->post()->create([
            'user_id' => auth()->id(),
            'image' => $request->image ?? '',
        ]);

        if ($request->tags) {
            $topic->tags()->sync($request->tags);
        }

        $redirectRoute = $request->input('viewName') === 'home' ? 'home' : 'listAllTopics';

        return redirect()->back()->with('success', 'Topic created successfully.');
    }

    public function updateTopic(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'viewName' => 'nullable|string', 
        ]);
    
        $topic = Topic::findOrFail($id);
        
        $topic->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);
    
        if ($request->has('tags')) {
            $topic->tags()->sync($request->tags);
        } else {
            $topic->tags()->sync([]);
        }
    
        $redirectRoute = $request->viewName === 'home' ? 'home' : 'listAllTopics';
    
        return redirect()->route($redirectRoute)->with('success', 'Topic updated successfully.');
    }

    public function updateTopicFromHome(Request $request, $id){
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array', 
            'tags.*' => 'exists:tags,id' 
        ]);

        $topic = Topic::findOrFail($id);

        if ($topic->post->user_id !== Auth::id()) {
            return redirect()->route('home')->withErrors('Você não tem permissão para editar este tópico.');
        }

        $topic->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        if ($request->has('tags')) {
            $topic->tags()->sync($request->tags);
        }

        return redirect()->route('home')->with('success', 'Tópico atualizado com sucesso.');
    }

    public function deleteTopic($id)
    {
        $topic = Topic::findOrFail($id);

        $topic->tags()->detach();
        $topic->comments()->delete();
        $topic->post()->delete();
        $topic->delete();

        return redirect()->route('listAllTopics')->with('success', 'Topic deleted successfully.');
    }

    public function deleteTopicHome($id)
    {
        $topic = Topic::findOrFail($id);

        $topic->tags()->detach();
        $topic->comments()->delete();
        $topic->post()->delete();
        $topic->delete();

        return redirect()->route('home')->with('success', 'Topic deleted successfully.');
    }

    public function searchTopics(Request $request)
    {
        $query = $request->input('query');
        $topics = Topic::where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();

        $categories = Category::all();
        $suggestedUsers = User::inRandomOrder()->take(5)->get();
        $tags = Tag::all();

        return view('welcome', compact('topics', 'categories', 'suggestedUsers', 'tags'));
    }

    public function listNewestTopics()
    {
        $topics = Topic::orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suggestedUsers = User::inRandomOrder()->take(5)->get();

        return view('welcome', compact('topics', 'categories', 'suggestedUsers'));
    }

    public function listMostViewedTopics()
    {
        $topics = Topic::with(['post'])
        ->whereHas('post', function ($query) {
            $query->orderBy('votes_count', 'desc');
        })
        ->take(10)
        ->get();

        $categories = Category::all();
        $suggestedUsers = User::inRandomOrder()->take(5)->get();

    return view('welcome', compact('topics', 'categories', 'suggestedUsers'));
    }

}
