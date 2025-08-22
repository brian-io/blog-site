<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(Request $request, Comment $comment)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to vote.'
            ], 403);
        }

        $validated = $request->validate([
            'vote' => 'required|in:1,-1'
        ]);

        $user = Auth::user();
        $voteType = (int) $validated['vote'];

        $voteResp = $user->voteOnComment($comment, $voteType);

        return response()->json($voteResp);
    }
}