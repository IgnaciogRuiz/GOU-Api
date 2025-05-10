<!doctype html>
<html lang="en" data-theme="{{ $config->get('ui.theme', 'light') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="color-scheme" content="{{ $config->get('ui.theme', 'light') }}">
    <title>{{ $config->get('ui.title', config('app.name') . ' - API Docs') }}</title>

    <script src="https://unpkg.com/@stoplight/elements@8.3.4/web-components.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@stoplight/elements@8.3.4/styles.min.css">
</head>

<body style="height: 100vh; overflow-y: hidden">
    <elements-api
        id="docs"
        tryItCredentialsPolicy="{{ $config->get('ui.try_it_credentials_policy', 'omit') }}"
        router="hash"
        @if($config->get('ui.hide_try_it')) hideTryIt="true" @endif
        @if($config->get('ui.hide_schemas')) hideSchemas="true" @endif
        logo="{{ $config->get('ui.logo') }}"
        @if($config->get('ui.layout')) layout="{{ $config->get('ui.layout') }}" @endif
        />
        <script>
            (async () => {
                const docs = document.getElementById('docs');
                docs.apiDescriptionDocument = @json($spec);
            })();
        </script>
</body>

</html>