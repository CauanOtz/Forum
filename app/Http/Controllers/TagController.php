<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function listAllTags()
    {
        $tags = Tag::all();
        return view('tags.listAllTags', ['tags' => $tags]);
    }

    public function listTagById($id)
    {
        $tag = Tag::findOrFail($id);
        return view('tags.listTagById', ['tag' => $tag]);
    }

    public function createTag(Request $request)
    {
        $request->validate([
            'id' => 'required|int|max:255',
            'name' => 'required|string|max:255',
  
        ]);

        $tag = Tag::create([
            'id' => $request->id,
            'name' => $request->name,

        ]);

        return redirect()->route('listAllTags')->with('success', 'Tag created successfully');
    }

    public function editTag($id)
    {
        $tag = Tag::findOrFail($id);
        return view('tags.editTag', ['tag' => $tag]);
    }

    public function updateTag(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|int|max:255',
            'name' => 'required|string|max:255',
            
        ]);

        $tag = Tag::findOrFail($id);
        $tag->name = $request->name;

        $tag->save();

        return redirect()->route('listAllTags')->with('success', 'Tag updated successfully');
    }

    public function deleteTag($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('listAllTags')->with('success', 'Tag deleted successfully');
    }
}
