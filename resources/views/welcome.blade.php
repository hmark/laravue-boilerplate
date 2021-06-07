<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravue Boilerplate</title>
        <link rel="stylesheet" href={{ asset('css/app.css') }}>
    </head>
    <body class="antialiased">
        <div id="app">
            <dashboard />
        </div>
        <script>
            window.config = <?php echo json_encode([
                'isAuth' => auth()->check(),
            ]); ?>
        </script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
