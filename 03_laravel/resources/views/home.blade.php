@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>Home</h1>
    <p>Read the <a href="{{ route('posts.index') }}">posts</a> or leave us your <a href="{{ route('feedback.create') }}">feedback</a>.</p>
@endsection
