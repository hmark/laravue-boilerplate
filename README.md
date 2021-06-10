# Laravue Boilerplate project

## Tech Stack

-   Laravel 8
-   Vue 3
-   Bootstrap 5
-   Css.gg icons
-   Vee-Validate 4 (using Yup schemas)
-   Axios
-   Vuex
-   Laravel BenSampo Enums

## Features

-   Controller->Service->Model Laravel code architecture
-   Stateful API using sessions
-   Auth (register, login, logout)
-   I18n support for Vue with backend caching
-   Error handling support
-   Requests DTO scaffolding

## Setup

-   Clone repository
-   Create configuration file `cp .env.example .env`
-   Generate app key `php artisan key:generate`
-   Execute migrations `php artisan migrate`
-   Install modules `composer update`
-   Install node modules `npm install`
-   Build app using `npm run dev` or `npm run prod`

## TODO

-   Add Laravel Sanctum
-   Add Vee-validate error messages i18n support
-   Add Vee-validate form checkbox boolean rule
-   Add admin role
-   Add admin interface support
-   Add resources crud support
-   Add client-server time sync using ISO format and frontend library (luxon?)
-   Add pagination support
-   Restrict access for admin assets
-   Restrict access for development assets in production environment
-   Add auth tests
-   Refactor Modal and Forms boilerplate code
-   Replace BenSampo Enums with native PHP 8.1 enums
