@extends('layouts.app')

@section('title', 'Feedback')

@section('content')
    <h1>Feedback</h1>

    @if (session('success'))
        <p><strong>{{ session('success') }}</strong></p>
    @endif

    <form method="POST" action="{{ route('feedback.store') }}">
        @csrf

        <p>
            <label>Name<br><input name="name" value="{{ old('name') }}"></label>
            @error('name') <br>{{ $message }} @enderror
        </p>

        <p>
            <label>Email<br><input name="email" value="{{ old('email') }}"></label>
            @error('email') <br>{{ $message }} @enderror
        </p>

        <p>
            <label>Subject<br>
                <select name="subject">
                    @foreach ($subjects as $subject)
                        <option @selected(old('subject') === $subject)>{{ $subject }}</option>
                    @endforeach
                </select>
            </label>
            @error('subject') <br>{{ $message }} @enderror
        </p>

        <p>
            <label>Message<br><textarea name="message" rows="5" cols="40">{{ old('message') }}</textarea></label>
            @error('message') <br>{{ $message }} @enderror
        </p>

        <button type="submit">Send</button>
    </form>
@endsection
