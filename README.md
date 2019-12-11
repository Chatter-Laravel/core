<p align="center"><img width="300" src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/logo.png"></p>

<p align="center">
<img src="https://github.styleci.io/repos/7548986/shield?style=flat" alt="Build status">
</p>

# Chatter - Laravel Forum Package

This is a Vue + Tailwind CSS + Laravel (PWA) forum package.

Chatter is a single page application to create forums on Laravel applications with ease.

This package is inspired on the [thedevdojo/chatter](https://github.com/thedevdojo/chatter) package

## Installation

Quick Note: If this is a new project, make sure to install the default user authentication provided with Laravel. `php artisan make:auth`

1. Include the package in your project

    ```
    composer require "chatter-laravel/core:dev-master"
    ```

2. Run the preset command

    ```
    php artisan preset chatter
    ```

3. Add the CanDiscuss trait to your User model

    ```
    composer dump-autoload
    ```

Now, visit your site.com/forums and you should see your new forum in front of you!

## Configuration

When you published the vendor assets you added a new file inside of your `config` folder which is called `config/chatter.php`. This file contains a bunch of configuration you can use to configure your forums

## Screenshots

<img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-demo.gif" alt="Laravel chatter forum demo" style="max-width:600px;">
<img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum.png" alt="Laravel chatter forum" style="max-width:800px;">
<img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum-2.png" alt="Laravel chatter forum" style="max-width:800px;">
<img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum-3.png" alt="Laravel chatter forum" style="max-width:800px;">
<img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum-mobile.png" alt="Laravel chatter forum" style="max-width:200px;">