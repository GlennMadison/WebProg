<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
        return Forum::with(['user', 'comments'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image',
        ]);

        $path = $request->file('image') ? $request->file('image')->store('forum_images', 'public') : null;

        $forum = Forum::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
            'image_path' => $path,
        ]);

        return response()->json($forum, 201);
    }
}