<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $forumId)
{
    $request->validate(['body' => 'required']);

    $comment = Comment::create([
        'user_id' => auth()->id(),
        'forum_id' => $forumId,
        'body' => $request->body,
    ]);

    return response()->json($comment, 201);
}

}
