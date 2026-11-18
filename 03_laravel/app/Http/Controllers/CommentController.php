<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        $data = $request->validate([
            'author' => 'required|string|max:50',
            'body' => 'required|string|max:1000',
            'target' => 'sometimes|required|in:post,category',
        ]);

        $commentable = ($data['target'] ?? 'post') === 'category' ? $post->category : $post;
        unset($data['target']);
        $commentable->comments()->create($data);

        return redirect()->route('posts.show', $post)->with('success', 'Comment added.');
    }
}
