<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SwaggerUI" />
    <title>Project Management API</title>

    {{-- Icon and Swagger --}}
    <script type="text/javascript">
        window.onload = () => {
            const protocol = window.location.protocol;
            const host = window.location.host;
            const baseUrl = `${protocol}//${host}`;
            const faviconUrl = `${baseUrl}/favicon.png`;

            const linkElement = document.createElement('link');
            linkElement.rel = 'shortcut icon';
            linkElement.href = faviconUrl;
            linkElement.type = 'image/x-icon';

            document.head.appendChild(linkElement);

            const openApiUrl = `${baseUrl}/docs/openapi.yaml`;
            window.ui = SwaggerUIBundle({
                url: openApiUrl,
                dom_id: '#swagger-ui',
            });
        };
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui.css" />
</head>

<body class="antialiased">
    <div id="swagger-ui"></div>
    <script src="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui-bundle.js" crossorigin></script>
</body>

</html>
