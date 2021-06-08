# Laravue Boilerplate project

## Tech Stack

-   Laravel 8
-   Vue 3
-   Bootstrap 5
-   Css.gg icons
-   Vee-Validate 4 (using Yup schemas)
-   Laravel BenSampo Enums

## Features

-   Controller->Service->Model Laravel code architecture
-   Client-Server API scaffolding
-   Auth (register, login, logout)
-   I18n support for Vue with backend caching
-   Error handling support
-   Requests DTO scaffolding

## Setup

-   Clone repository
-   Create configuration file `cp .env.example .env`
-   Generate app key `php artisan key:generate`
-   Install modules `composer update`
-   Install node modules `npm install`
-   Build app using `npm run dev` or `npm run prod`

## TODO

-   Add response errors display to frontend by extending frontend validation library functionality
-   Add Laravel Sanctum for communicaton between frontend and backend
-   Replace ThrottlesLogins class with Laravel 8 Improved Rate Limitting and remove Laravel/ui dependency
-   Add loader to submit buttons when waiting for server response
-   Add Vee-validate error messages i18n support
-   Add Vee-validate form checkbox boolean rule
-   Use vuex for storing auth user instead of reloading page after register/login
-   Add admin role
-   Add admin interface support
-   Add resources crud support
-   Add client-server time sync using ISO format and frontend library (luxon?)
-   Add pagination support
-   Restrict access for admin assets
-   Restrict access for development assets in production environment
-   Add auth tests
-   Replace BenSampo Enums with native PHP 8.1 enums
