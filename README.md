# Laravue Boilerplate project

## Tech Stack

-   Laravel 10
-   Vue 3.2.47
-   Vite 4
-   Axios 1.1.2
-   Bootstrap 5.2.3
-   Bootstrap Icons 1.10.3
-   Laravel Sanctum 3.2
-   Pinia 2.0.32
-   Laravel Actions 2.5
-   Day.js 1.11.9
-   Vue Valid Forms 0.0.4

## Setup

-   Clone repository
-   Create configuration file `cp .env.example .env`
-   Install modules `composer update`
-   Generate app key `php artisan key:generate`
-   Execute migrations `php artisan migrate`
-   Install node modules `npm install`
-   Build app using `npm run dev` or `npm run build`
-   Start app `php artisan serve`


## Optional Setup

-   Setup VS Code tasks `mv .vscode/tasks.json.example .vscode/tasks.json`
-   Update UsersSeeder `database/seeders/UsersSeeder.php` and seed users table `php artisan db:seed --class=UsersSeeder`
-   Disable backend registration and token routes `routes/api.php` and on the frontend `resources/js/router.ts` + `resources/js/pages/Login.vue`
-   Update Readme
