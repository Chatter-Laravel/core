<p align="center"><img width="300" src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/logo.png"></p>

<p align="center">
<img src="https://github.styleci.io/repos/7548986/shield?style=flat" alt="Build status">
</p>

# Chatter - Laravel Forum Package

This is a Vue + Tailwind CSS + Laravel (PWA) forum package.

**This is a community package inspired on the [thedevdojo/chatter](https://github.com/thedevdojo/chatter) package**

## Installation

Quick Note: If this is a new project, make sure to install the default user authentication provided with Laravel. `php artisan make:auth`

1. Include the package in your project

    ```
    composer require "chatter-laravel/core:dev-master"
    ```

2. Add the service provider to your `config/app.php` providers array:

   **If you're installing on Laravel 5.5+ skip this step**

    ```
    Chatter\Core\ChatterServiceProvider::class,
    ```

3. Publish the Vendor Assets files by running:

    ```
    php artisan vendor:publish --provider="Chatter\Core\ChatterServiceProvider"
    ```

4. Now that we have published a few new files to our application we need to reload them with the following command:

    ```
    composer dump-autoload
    ```

5. Run Your migrations:

    ```
    php artisan migrate
    ```

    Quick tip: Make sure that you've created a database and added your database credentials in your `.env` file.

6. Lastly, run the seed files to seed your database with a little data:

    ```
    php artisan db:seed --class=ChatterTableSeeder
    ```

Now, visit your site.com/forums and you should see your new forum in front of you!

## Upgrading

Make sure that your composer.json file is requiring the latest version of chatter:

```
"chatter-laravel/core": :dev-master"
```

Then you'll run:

```
composer update
```

Next, you may want to re-publish the chatter assets, chatter config, and the chatter migrations by running the following:

```
php artisan vendor:publish --tag=chatter_assets --force
php artisan vendor:publish --tag=chatter_config --force
php artisan vendor:publish --tag=chatter_migrations --force
```

Next to make sure you have the latest database schema run:

```
php artisan migrate
```

And you'll be up-to-date with the latest version :)

## Configuration

When you published the vendor assets you added a new file inside of your `config` folder which is called `config/chatter.php`. This file contains a bunch of configuration you can use to configure your forums

## Screenshots
<img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum.png" alt="Laravel chatter forum" style="max-width:800px;">
<img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum-2.png" alt="Laravel chatter forum" style="max-width:800px;">
<img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum-3.png" alt="Laravel chatter forum" style="max-width:800px;">
<img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum-mobile.png" alt="Laravel chatter forum" style="max-width:200px;">
<img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum-mobile-2.png" alt="Laravel chatter forum" style="max-width:200px;">
<img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum-mobile-3.png" alt="" style="max-width:200px;">