<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravue Boilerplate</title>
        @vite('resources/js/app.ts')
    </head>
    <body class="antialiased">
        <div id="app">
            <dashboard />
        </div>
    </body>
</html>
