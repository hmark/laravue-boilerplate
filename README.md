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
