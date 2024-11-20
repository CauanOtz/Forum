<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Rate;

class RateController extends Controller
{
    public function ratePost(Request $request, $postId)
    {
  
        $request->validate(['vote' => 'required|boolean']);
    $voteValue = $request->vote ? 1 : 0;

    $post = Post::findOrFail($postId);

    $rate = Rate::updateOrCreate(
        ['post_id' => $postId, 'user_id' => auth()->id()],
        ['vote' => $voteValue]
    );

    $likesCount = Rate::where('post_id', $postId)->where('vote', 1)->count();
    $dislikesCount = Rate::where('post_id', $postId)->where('vote', 0)->count();

    $votesCount = $likesCount + $dislikesCount;

    $post->update(['votes_count' => $votesCount]);

    return response()->json([
        'success' => true,
        'likes_count' => $likesCount,
        'dislikes_count' => $dislikesCount,
        'votes_count' => $votesCount,
        ]);
    }

}
