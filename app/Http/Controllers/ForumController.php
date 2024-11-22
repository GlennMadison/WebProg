<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;

class ForumController extends Controller
{
    public function index()
{
    return Forum::with('user', 'comments')->get();
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'body' => 'required',
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
