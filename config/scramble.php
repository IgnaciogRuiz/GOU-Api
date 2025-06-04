<?php

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [

    'api_path' => 'api',

    'api_domain' => null,

    'export_path' => 'api.json',

    'info' => [
        'version' => env('API_VERSION', '1.0.0'),
        'description' => <<<MARKDOWN
        API pública para el backend de la aplicación móvil **GOU!**, una plataforma de carpooling desarrollada en Argentina.

        Esta API provee endpoints RESTful para:

        - Registro, login y validación de identidad (incluyendo verificación de DNI).
        - Creación, edición y eliminación de viajes.
        - Gestión de usuarios, vehículos y pasajeros.
        - Solicitudes y confirmaciones de viaje.
        - Seguridad y autenticación basada en tokens Bearer.

        Todos los endpoints están versionados y requieren autorización mediante `Authorization: Bearer {token}` salvo los públicos (como registro e inicio de sesión).
        MARKDOWN,
    ],

    'ui' => [
        'title' => 'GOU RESTful API',
        'theme' => 'dark',
        'hide_try_it' => false,
        'hide_schemas' => false,
        'logo' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8Z0vxjYvKxAHrfO8wFFOwroZt41hbenuqhg&s', // Podés agregar una URL si tenés logo
        'try_it_credentials_policy' => 'omit',
        'layout' => 'responsive',
    ],

    'servers' => null,

    'enum_cases_description_strategy' => 'description',

    'middleware' => [
        'api',
        RestrictedDocsAccess::class,

    ],

    'extensions' => [],

];
