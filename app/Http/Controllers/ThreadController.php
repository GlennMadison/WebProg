<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::with('user')->latest()->paginate(10);

        
        return view('threads.thread.index', compact('threads'));
    }

    public function create(Request $request)
    {

        return view('threads.thread.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        return redirect()->route('threads.thread.show', $thread)
            ->with('success', 'Thread created successfully.');


    }

    public function show(Thread $thread)
    {
        $thread->load('user', 'comments.user', 'comments.childComments.user');

        return view('threads.thread.show', compact('thread'));
    }
}
