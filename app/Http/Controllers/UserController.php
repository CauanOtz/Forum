<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Topic;
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

        return redirect()->route('listAllUsers');
    }
}

    public function UpdateUser(Request $request, $id) {
        $user = User::find($id);

        if(!$user){
            return redirect()->route('listAllUsers')->with('error', 'Usuário não encontrado');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->filled('password')){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('myAccount')->with('message', 'Alteração funcionou');

    }

    public function deleteUser(Request $request, $id) {
        $user = User::where('id', $id)->delete();
        return redirect()->route('listAllUsers');
    }

    public function myAccount() {
        $user = Auth::user();
        return view('users.profile', ['user' => $user]);
    }

    public function person($id)
    {
    // Encontrar o usuário
        $user = User::findOrFail($id);

        $topics = Topic::whereHas('post', function($query) use ($id) {
            $query->where('user_id', $id);
        })->get();
        
        return view('users.person', compact('user', 'topics'));
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
        $user->delete();
        
        Auth::logout();

        return redirect()->route('login')->with('success', 'Account deleted successfully');
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
    
        return redirect()->back()->with('success', 'Usuário ' . ' id: ' . $id . ' nome: ' . $user->name . ' desbanido com sucesso.');
    }
    

}

