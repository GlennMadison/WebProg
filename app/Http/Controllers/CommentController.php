<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $forumId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'forum_id' => $forumId,
            'body' => $request->body,
        ]);

        return response()->json($comment, 201);
    }
}
