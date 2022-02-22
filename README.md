# Laravue Boilerplate project

## Tech Stack

-   Laravel 9
-   Vue 3
-   Bootstrap 5
-   Css.gg icons
-   Laravel Sanctum
-   Axios
-   Vee-Validate 4 (using Yup schemas)
-   Vuex

## Features

-   Controller->Service->Model Laravel code architecture
-   Stateful API using Laravel Sanctum
-   Auth (register, login, logout)
-   I18n support for Vue with backend caching
-   Error handling support
-   Requests DTO scaffolding

## Setup

-   Clone repository
-   Create configuration file `cp .env.example .env`
-   Install modules `composer update`
-   Generate app key `php artisan key:generate`
-   Execute migrations `php artisan migrate`
-   Install node modules `npm install`
-   Build app using `npm run dev` or `npm run prod`

## TODO

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
