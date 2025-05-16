# GOU API

API para la aplicación móvil **GOU**, un sistema de carpooling que facilita la conexión entre conductores y pasajeros para compartir viajes de manera segura, eficiente y colaborativa.

Esta API está diseñada con **GraphQL** sobre REST para brindar flexibilidad en las consultas y mutaciones, optimizando el consumo de datos en dispositivos móviles.

---

## Características principales

-   **GraphQL**: consultas flexibles que permiten pedir exactamente los datos necesarios.
-   **Rest**: consultas a endpoint definidos.
-   **Autenticación y autorización** mediante middleware Sanctum .
-   Manejo de usuarios, vehículos, viajes, reservas, calificaciones y más.
-   Relaciones entre modelos con resolvers automáticos (`@hasMany`, `@belongsTo`, `@belongsToMany`).
-   Validación y autorización integradas para proteger los endpoints.
-   Inputs para mutaciones que simplifican la creación y actualización de datos en graphQL.

---

## Tecnologías usadas

-   **Laravel** (PHP Framework)
-   **Nuwave Lighthouse** para GraphQL en Laravel
-   **MySQL** como base de datos
-   **GraphQL** para la comunicación entre cliente y servidor
-   **Sanctum** para la autenticacion por API Tokens
-   **Blueprint** para la creacion de modelos controladores y migraciones
-   **Scramble** para generae la documentacion del REST

---

## Instalación y configuración

Sigue estos pasos para levantar la API localmente:

```bash
# 1. Clonar el repositorio
git clone https://github.com/tuusuario/gou-api.git
cd gou-api

# 2. Instalar dependencias
composer install

# 3. Configurar variables de entorno
# Copia .env.example a .env y ajusta tus parámetros de base de datos, claves, etc.

# 4. Ejecutar migraciones y seeders
php artisan migrate --seed

# 5. Ejecutar servidor local
php artisan serve
```
