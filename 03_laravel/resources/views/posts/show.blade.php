@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <h1>{{ $post->title }}</h1>

    <p class="muted">
        Category: <a href="{{ route('posts.index', ['category' => $post->category_id]) }}">{{ $post->category->name }}</a>
        &middot; Tags: {{ $post->tags->pluck('name')->join(', ') ?: '-' }}
        &middot; {{ $post->is_published ? 'Published '.$post->published_at?->format('Y-m-d H:i') : 'Draft' }}
    </p>

    <p>{{ $post->body }}</p>

    @foreach ($post->category->comments as $comment)
        <p>Category comment: <strong>{{ $comment->author }}</strong> — {{ $comment->body }}</p>
    @endforeach

    <p><a href="{{ route('posts.edit', $post) }}">Edit</a></p>

    <h2>Comments ({{ $post->comments->count() }})</h2>

    @foreach ($post->comments as $comment)
        <p><strong>{{ $comment->author }}</strong> <span class="muted">{{ $comment->created_at->format('Y-m-d H:i') }}</span><br>{{ $comment->body }}</p>
    @endforeach

    <form method="POST" action="{{ route('posts.comments.store', $post) }}">
        @csrf
        <p>
            <label>Comment on
                <select name="target">
                    <option value="post">This post</option>
                    <option value="category" @selected(old('target') === 'category')>Category: {{ $post->category->name }}</option>
                </select>
            </label>
            @error('target') <br><span class="error">{{ $message }}</span> @enderror
        </p>
        <p>
            <label>Your name<br><input name="author" value="{{ old('author') }}"></label>
            @error('author') <br><span class="error">{{ $message }}</span> @enderror
        </p>
        <p>
            <label>Comment<br><textarea name="body" rows="3" cols="40">{{ old('body') }}</textarea></label>
            @error('body') <br><span class="error">{{ $message }}</span> @enderror
        </p>
        <button type="submit">Add comment</button>
    </form>
@endsection
