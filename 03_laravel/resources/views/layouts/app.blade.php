<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Blog</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('partials.header')

    <main>
        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
