@extends('layouts.app')

@section('title', 'Submissions')

@section('content')
    <h1>Submissions</h1>

    @if ($items->isEmpty())
        <p>No submissions yet.</p>
    @else
        <table border="1" cellpadding="4">
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
            </tr>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item['created_at'] }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['subject'] }}</td>
                    <td>{{ $item['message'] }}</td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
