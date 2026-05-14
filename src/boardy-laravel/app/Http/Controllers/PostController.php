<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('author')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'body' => 'required|string',
        ]);

        $request->user()->posts()->create($data);

        return redirect()->route('posts.index')->with('success', 'Пост создан');
    }

    public function show(Post $post)
    {
        $post->load('author', 'comments.author');
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            abort(403, 'This action is unauthorized.');
        }
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            abort(403, 'This action is unauthorized.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:200',
            'body' => 'required|string',
        ]);

        $post->update($data);

        return redirect()->route('posts.show', $post)->with('success', 'Пост обновлён');
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            abort(403, 'This action is unauthorized.');
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Пост удалён');
    }
}
