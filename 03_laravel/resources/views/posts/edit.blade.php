@extends('layouts.app')

@section('title', 'Edit post')

@section('content')
    <h1>Edit post</h1>

    <form method="POST" action="{{ route('posts.update', $post) }}">
        @method('PUT')
        @include('posts._form')
    </form>
@endsection
