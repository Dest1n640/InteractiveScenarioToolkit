<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('category', 'tags')
            ->when($request->integer('category'), fn ($query, $id) => $query->inCategory($id))
            ->latest()
            ->get();

        return view('posts.index', ['posts' => $posts, 'categories' => Category::withCount('posts')->get()]);
    }

    public function create()
    {
        return view('posts.create', ['post' => new Post, 'categories' => Category::all(), 'tags' => Tag::all()]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->saveWithTags($request->safe()->except('tags'), $request->tagIds());

        return redirect()->route('posts.show', $post)->with('success', 'Post created.');
    }

    public function show(Post $post)
    {
        $post->load('category.comments', 'tags', 'comments');

        return view('posts.show', ['post' => $post]);
    }

    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post->load('tags'), 'categories' => Category::all(), 'tags' => Tag::all()]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->saveWithTags($request->safe()->except('tags'), $request->tagIds());

        return redirect()->route('posts.show', $post)->with('success', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post moved to trash.');
    }

    public function trash()
    {
        return view('posts.trash', ['posts' => Post::onlyTrashed()->with('category')->latest('deleted_at')->get()]);
    }

    public function restore(Post $post)
    {
        $post->restore();

        return redirect()->route('posts.show', $post)->with('success', 'Post restored.');
    }
}
