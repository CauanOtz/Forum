<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function listAllCategories()
    {
        $categories = Category::all();
        return view('category.listAllCategories', ['categories' => $categories]);
    }

    public function listCategoryById($id)
    {
        $categories = Category::findOrFail($id);
        $suggestedUsers = User::inRandomOrder()->take(5)->get();
        $tags = Tag::all();

        return view('category.listCategoryByid', compact('categories', 'suggestedUsers', 'tags'));
    }


    public function showCategories(){
        $categories = Category::all();
        $suggestedUsers = User::inRandomOrder()->take(5)->get();
        $tags = Tag::all();

        return view('category.showCategories', compact('categories', 'suggestedUsers', 'tags'));
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // $category = Category::create([
        //     'title' => $request->title,
        //     'description' => $request->description,
        // ]);

        $category = new Category();
        $category->title = $request->title;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('listAllCategories')->with('success', 'Category created successfully');
    }

    
    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('category.editCategory');
    }

    public function updateCategory(Request $request, $id)
    {
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

    
        $category = Category::findOrFail($id);

        $category->title = $request->title;
        $category->description = $request->description;

        $category->save();

        return redirect()->route('listAllCategories')->with('success', 'Category updated successfully');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('listAllCategories')->with('success', 'Category deleted successfully');
    }

    public function show($id)
    {
        $categories = Category::with('topics')->findOrFail($id); 
        return view('category.show', compact('categories'));
    }

}


