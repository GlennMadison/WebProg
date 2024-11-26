<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Thread $thread)
    {
        // Validate the request data
        $validated = $request->validate([
            'body' => 'required|string',
            'parent_comment_id' => 'nullable|exists:comments,id',
        ]);

        // Check if the comment is a reply
        $parentCommentId = $validated['parent_comment_id'] ?? null;

        // If this is a reply (parent_comment_id is not null), set thread_id to null
        $threadId = $parentCommentId ? null : $thread->id;

        // Create a new comment, either on the thread or as a reply
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
            'thread_id' => $threadId, // Null if it's a reply, else thread id
            'parent_comment_id' => $parentCommentId, // Set the parent_comment_id if it's a reply
        ]);

        // Redirect back to the thread
        return redirect()->route('threads.show', $thread)
            ->with('success', 'Comment posted successfully.');
    }

}
