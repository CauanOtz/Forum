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

    $existingVote = Rate::where('post_id', $postId)
                        ->where('user_id', auth()->id())
                        ->first();

    if ($existingVote) {
        if ($existingVote->vote == $voteValue) {
            // Neutralizar voto se o usuário clicar no mesmo botão
            $existingVote->delete();
        } else {
            // Atualizar o voto para o novo valor
            $existingVote->update(['vote' => $voteValue]);
        }
    } else {
        // Criar um novo voto
        Rate::create([
            'post_id' => $postId,
            'user_id' => auth()->id(),
            'vote' => $voteValue
        ]);
    }

    // Recalcular likes e dislikes
    $likesCount = Rate::where('post_id', $postId)->where('vote', 1)->count();
    $dislikesCount = Rate::where('post_id', $postId)->where('vote', 0)->count();

    // Atualizar a contagem de votos no Post
    $post->update(['votes_count' => $likesCount + $dislikesCount]);

    return response()->json([
        'success' => true,
        'likes_count' => $likesCount,
        'dislikes_count' => $dislikesCount,
        'votes_count' => $likesCount + $dislikesCount,
        'user_vote' => $existingVote ? ($existingVote->vote == $voteValue ? null : $voteValue) : $voteValue, // Voto atual ou null se neutralizado
    ]);
}

    

}
