@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <h1>Posts</h1>

    <p><a href="{{ route('posts.create') }}">+ New post</a></p>

    <form method="GET" action="{{ route('posts.index') }}">
        <label>Category
            <select name="category">
                <option value="">All categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }} ({{ $category->posts_count }})</option>
                @endforeach
            </select>
        </label>
        <button type="submit">Filter</button>
    </form>

    @if ($posts->isEmpty())
        <p class="muted">No posts.</p>
    @else
        <table>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Tags</th>
                <th>Published</th>
                <th></th>
            </tr>
            @foreach ($posts as $post)
                <tr>
                    <td><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></td>
                    <td>{{ $post->category->name }}</td>
                    <td>{{ $post->tags->pluck('name')->join(', ') }}</td>
                    <td>{{ $post->is_published ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('posts.edit', $post) }}">Edit</a>
                        <form class="inline" method="POST" action="{{ route('posts.destroy', $post) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
