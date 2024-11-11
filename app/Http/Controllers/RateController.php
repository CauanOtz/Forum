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
        try {
            $post = Post::findOrFail($postId);
    
            Rate::create([
                'vote' => true,
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
    
            return response()->json(['success' => true, 'message' => 'Avaliação criada com sucesso']);
        } catch (\Exception $e) {
            \Log::error('Erro ao avaliar post:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Erro ao avaliar post'], 500);
        }
    }

}
