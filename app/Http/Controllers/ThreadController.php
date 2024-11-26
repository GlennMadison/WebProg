<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index()
    {
        // Fetch all threads with user details, paginate the results
        $threads = Thread::with('user')->latest()->paginate(10);

        // Pass threads to the view
        return view('threads.index', compact('threads'));
    }

    public function create(Request $request)
    {

        return view('threads.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Create a new thread
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        return redirect()->route('threads.show', $thread)
            ->with('success', 'Thread created successfully.');


    }

    public function show(Thread $thread)
    {
        // Load the thread with its user, comments, and nested comments
        $thread->load('user', 'comments.user', 'comments.childComments.user');

        // Pass the thread to the view
        return view('threads.show', compact('thread'));
    }
}
