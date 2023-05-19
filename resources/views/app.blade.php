<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>Sheikh.ai | World's 1st AI Sheikh</title>
</head>
<body>
    <div id="app">
        <app-component></app-component>
    </div>
    <link href="{{ Vite::asset('resources/sass/app.scss') }}" rel="stylesheet">
    <script src="{{ Vite::asset('resources/js/app.js') }}" type="text/javascript"></script>
</body>
</html>
