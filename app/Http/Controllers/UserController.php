<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Topic;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function listAllUsers() {

        $users = User::all(); // Busca todos os usuários
        return view('users.listAllUsers', ['users' => $users]); // Retorna a view com os dados dos usuários
    }

    public function listUserById(Request $request,$id) {
        $user = User::where('id', $id)->first(); //Busca um usuário pelo ID
        return view('users.profile', ['user' => $user]);
    }

    
public function register(Request $request) {
    if ($request->isMethod('GET')) {
        return view('users.create');
    } else {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}

public function UpdateUser(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->route('listAllUsers')->with('error', 'Usuário não encontrado');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if (auth()->user()->id !== $user->id && auth()->user()->role === 'admin') {
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);
        $user->role = $request->role; 
    }

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->storeAs(
            'images',
            time() . '_' . $request->file('image')->getClientOriginalName(),
            'public'
        );
        $user->photo = $imagePath;
    }

    $user->save();

    $redirectRoute = auth()->user()->id === $user->id ? 'myAccount' : 'listAllUsers';
    return redirect()->route($redirectRoute)->with('message', 'Alteração funcionou');
}


    public function deleteUser(Request $request, $id) {
        $user = User::where('id', $id)->delete();
        return redirect()->route('listAllUsers');
    }

    public function myAccount() {
        $user = Auth::user();
        $suggestedUsers = User::inRandomOrder()->take(5)->get();
        $categories = Category::all();
        $tags = Tag::all();
        return view('users.profile', compact('user', 'suggestedUsers', 'categories', 'tags'));
    }

    public function person($id)
    {
        $user = User::findOrFail($id);

        $topics = Topic::whereHas('post', function($query) use ($id) {
            $query->where('user_id', $id);
        })->get();
        
        $suggestedUsers = User::inRandomOrder()->take(5)->get();
        $categories = Category::all();
        $tags = Tag::all();
        return view('users.person', compact('user', 'topics', 'suggestedUsers', 'tags', 'categories'));
    }

    public function question()
{
    $userId = auth()->id();

    // Buscar tópicos pelo autor do post
    $topics = Topic::whereHas('post', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })
    ->with(['post', 'comments'])
    ->get();

    // Adicionar contagens de likes, dislikes e comentários
    $topics->each(function ($topic) {
        $topic->likes_count = $topic->post?->rates()
            ->where('vote', 1)
            ->count() ?? 0;

        $topic->dislikes_count = $topic->post?->rates()
            ->where('vote', 0)
            ->count() ?? 0;

        $topic->comments_count = $topic->comments->count();
    });
    $suggestedUsers = User::inRandomOrder()->take(5)->get();
    $categories = Category::all();
    $tags = Tag::all();
    $user = auth()->user();

    return view('users.question', compact('topics', 'user', 'suggestedUsers', 'categories', 'tags'));
}





    public function answers() {
        $user = Auth::user();
        return view('users.answers', ['user' => $user]);
    }

    public function likes() {
        $user = Auth::user();
        return view('users.likes', ['user' => $user]);
    }

    public function updateAccount(Request $request) {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('myAccount')->with('success', 'Account updated successfully');
    }

    public function deleteAccount() {
        $user = Auth::user();
        $user->topics()->each(function ($topic) {
            $topic->comments()->delete();
            $topic->delete();
        });
    
        $user->comments()->delete();
    
        $user->posts()->delete();
    
        $user->delete();

        Auth::logout();
    
        return redirect()->route('login')->with('success', 'Conta excluída com sucesso.');
    }

    public function listUserTopics($id)
    {
        $user = User::findOrFail($id);
        $topics = Topic::whereHas('post', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->get();
    
        return view('users.person', compact('user', 'topics'));
    }

    public function banUser($id) {
        $user = User::find($id);

        if(!$user) {
            return redirect()->route('listAllUsers')->with('error', 'Usuário não encontrado');
        }
        $user->is_banned = true;
        $user->save();

        return redirect()->back()->with('success', 'Usuário ' . 'id: '. $id . ' nome: ' . $user->name  . ' banido com sucesso.');
    }

    public function unbanUser($id) {
        $user = User::find($id);
    
        if (!$user) {
            return redirect()->route('listAllUsers')->with('error', 'Usuário não encontrado');
        }
    
        $user->is_banned = false;
        $user->save();
    
        return redirect()->back()->with('success', 'U   suário ' . ' id: ' . $id . ' nome: ' . $user->name . ' desbanido com sucesso.');
    }


}

