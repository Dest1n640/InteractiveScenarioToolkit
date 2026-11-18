@extends('layouts.app')

@section('title', 'New post')

@section('content')
    <h1>New post</h1>

    <form method="POST" action="{{ route('posts.store') }}">
        @include('posts._form')
    </form>
@endsection
