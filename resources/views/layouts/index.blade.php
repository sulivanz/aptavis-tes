<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aptavis Tes</title>
    <link href="{{ asset('bootstrap/bootstrap.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body style="background-color: lightgray">
    @include('layouts.navbar')
    <div class="container mt-5">
        @yield('content')
    </div>
    <script src="{{ asset('bootstrap/bootstrap.js') }}"></script>
    @stack('scripts')
</body>

</html>
