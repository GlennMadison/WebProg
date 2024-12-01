<?php

namespace App\Http\Controllers;

use App\Models\Comment;
<<<<<<< HEAD
=======
use App\Models\Thread;
>>>>>>> test
use Illuminate\Http\Request;

class CommentController extends Controller
{
<<<<<<< HEAD
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
=======
    public function store(Request $request, Thread $thread)
    {
        $validated = $request->validate([
            'body' => 'required|string',
            'parent_comment_id' => 'nullable|exists:comments,id',
        ]);

        $parentCommentId = $validated['parent_comment_id'] ?? null;

        $threadId = $parentCommentId ? null : $thread->id;

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
            'thread_id' => $threadId, 
            'parent_comment_id' => $parentCommentId, 
        ]);

        return redirect()->route('threads.thread.show', $thread)
            ->with('success', 'Comment posted successfully.');
    }

>>>>>>> test
}
