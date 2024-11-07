<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Rate;

class RateController extends Controller
{
    public function rate(Request $request, $postId)
    {
        try {
            $validatedData = $request->validate([
                'vote' => 'required|integer|in:1,-1',
            ]);

            $post = Post::findOrFail($postId);
            $rate = $post->rates()->updateOrCreate(
                ['user_id' => auth()->id()],
                ['vote' => $validatedData['vote']]
            );

            return response()->json(['success' => true, 'rate' => $rate, 'new_average' => $post->averageRating()]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
