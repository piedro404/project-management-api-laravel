<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="SwaggerUI" />

        <title>Project Management API</title>

        {{-- Icon --}}
        <link rel="shortcut icon" href={{url('favicon.png')}} type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        
        <!-- Styles -->
        <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui.css" />
    </head>
    <body class="antialiased">
        <div id="swagger-ui"></div>
        <script src="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui-bundle.js" crossorigin></script>
        <script>
        window.onload = () => {
            window.ui = SwaggerUIBundle({
                url: '{{ url('docs/openapi.yaml') }}',
                dom_id: '#swagger-ui',
            });
        };
        </script>
    </body>
</html>