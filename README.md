# Laravue Boilerplate project

## Tech Stack

-   Laravel 10
-   Vue 3.2.47
-   Vite 4
-   Axios 1.1.2
-   Bootstrap 5.2.3
-   Bootstrap Icons 1.10.3
-   Laravel Sanctum
-   Vee-Validate 4 (using Yup schemas)
-   Vuex

## Features

-   Controller->Service->Model Laravel code architecture
-   Stateful API using Laravel Sanctum
-   Auth (register, login, logout)
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
