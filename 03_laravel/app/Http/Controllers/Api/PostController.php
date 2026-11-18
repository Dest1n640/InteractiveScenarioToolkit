<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::published()->with('category', 'tags')->latest()->get());
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->saveWithTags($request->safe()->except('tags'), $request->tagIds());

        return new PostResource($post->load('category', 'tags'));
    }

    public function show(Post $post)
    {
        return new PostResource($post->load('category', 'tags', 'comments'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->saveWithTags($request->safe()->except('tags'), $request->tagIds());

        return new PostResource($post->load('category', 'tags'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->noContent();
    }
}
