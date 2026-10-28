@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>Home</h1>
    <p>Leave us your <a href="{{ route('feedback.create') }}">feedback</a>.</p>
@endsection
