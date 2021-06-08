# Laravue Boilerplate project

## Tech Stack

-   Laravel 8
-   Vue 3
-   Bootstrap 5
-   Css.gg icons
-   Laravel BenSampo Enums

## Features

-   Controller->Service->Model Laravel code architecture
-   Client-Server API scaffolding
-   Auth (register, login, logout)
-   I18n support for Vue with backend caching
-   Error handling support
-   Requests DTOs scaffolding

## Setup

-   Clone repository
-   Create configuration file `cp .env.example .env`
-   Generate app key `php artisan key:generate`
-   Install modules `composer update`
-   Install node modules `npm install`
-   Build app using `npm run dev` or `npm run prod`

## TODO

-   Add resources crud support
-   Add client-server time sync using ISO format and frontend library (luxon?)
-   Add frontend forms validation library (vee-validate?)
-   Add response errors display to frontend by extending frontend validation library functionality
-   Add admin interface support
-   Add Laravel Sanctum for communicaton between frontend and backend
-   Restrict access for admin assets
-   Restrict access for development assets in production environment
-   Replace BenSampo Enums with native PHP 8.1 enums
-   Replace ThrottlesLogins class with Laravel 8 Improved Rate Limitting and remove Laravel/ui dependency
-   Add auth tests
-   Use vuex for storing auth user instead of reloading page after register/login
