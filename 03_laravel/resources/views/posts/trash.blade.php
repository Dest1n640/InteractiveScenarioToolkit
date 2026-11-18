@extends('layouts.app')

@section('title', 'Trash')

@section('content')
    <h1>Trash</h1>

    @if ($posts->isEmpty())
        <p class="muted">Trash is empty.</p>
    @else
        <table>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Deleted at</th>
                <th></th>
            </tr>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category->name }}</td>
                    <td>{{ $post->deleted_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <form class="inline" method="POST" action="{{ route('posts.restore', $post) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit">Restore</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
