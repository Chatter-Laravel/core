<p align="center"><img width="300" src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/logo.png"></p>

<p align="center">
<img src="https://github.styleci.io/repos/7548986/shield?style=flat" alt="Build status">
<img src="https://img.shields.io/badge/Maintained%3F-yes-green.svg" alt="Maintained repository">
<a href="https://github.com/Chatter-Laravel/core/blob/master/license" target="_blank"><img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="MIT License"></a>
</p>

# Chatter - Laravel Forum Package

This is a Vue + Tailwind CSS + Laravel forum package. Chatter is a single page application to create forums on Laravel applications with ease.

**[See the youtube demo](https://youtu.be/HIaEsMWBV28)**

*This package is inspired on the [thedevdojo/chatter](https://github.com/thedevdojo/chatter) package*

## Installation

If you are planning to install Chatter on an already existing project, please check the ChatterPreset class and check which of the instalations steps you need to run, really dependes on what you got.

Chatter Branch | Chatter Version | Laravel version
--------------- | --------------- | ---------------
5.x|^5.8|^5.8
6.x|^6|^6
master|dev-master|^7

1. Install [Laravel 6](https://laravel.com/docs/6.x/installation#installing-laravel)
    If you are installing Chatter in an existing project skip this step.

2. Include the package in your project and publish the package views, configs, etc:

    ```bash
    $ composer require "chatter-laravel/core:^6"
    $ php artisan vendor:publish --provider "Chatter\\Core\\ChatterServiceProvider"
    $ composer dump-autoload
    ```

3. Run the install command and follow the instructions:

    ```bash
    $ php artisan chatter:install
    ```

    If you are installing Chatter in an existing project, include the *--plugin* option when you call the install command:
    ```bash
    $ php artisan chatter:install --plugin
    ```

    The installation command will take care of all that you need to install the forum: migrations, js components, tailwind, composer packages, node packages, etc.

4. Add the CanDiscuss and HasApiTokens trait to your *User model*. If you have Laravel Passport already installed on your project you probably already have the HasApiTokens trait in your *User model*:

    ```php
    <?php

    namespace App;

    use Chatter\Core\Traits\CanDiscuss;
    use Laravel\Passport\HasApiTokens;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class User extends Authenticatable
    {
        use HasApiTokens, Notifiable, CanDiscuss;
    ```

5. Chatter instalation command already installs [Laravel Passport](https://laravel.com/docs/5.8/passport#installation) but you need to add the CreateFreshApiToken middleware to your web middleware group in your *app/Http/Kernel.php* file:

    ```php
    'web' => [
        // Other middleware...
        \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
    ],
    ```

**If you are installing Chatter on a fresh Laravel instalation, go straight to step 9**

6. Make sure you have Tailwind CSS installed on your project. [Tailwind CSS instalation.](https://tailwindcss.com/docs/installation/)

7. Include the Chatter JS app into your *resources/js/app.js*:

    ```javascript
    require('./chatter/app')
    ```

8. Populate the categories of your forum. You can create a new seed for your project.

9. Run the Laravel server:

    ```bash
    $ php artisan serve
    ```

10. **Now, visit http://localhost:8000/forums and you should see your new forum in front of you!**

## Testing

There are some factories that generates some testing information on the database. Just run the seed to execute those factories:

```bash
$ php artisan db:seed --class ChatterTableSeeder
```

## Roadmap

- [x] Check compatiblity with Laravel 6
- [x] React to posts
- [x] Star this repository
- [ ] Pin a discussion
- [ ] Administration/moderation panel (block users, delete posts)
- [ ] Report discussion
- [ ] Edit posts and discussions (with versioning)
- [ ] Users profiles
- [ ] Users rewards
- [ ] Tag other users on discussions and posts
- [ ] Create tests
- [ ] Use Localization (translations)


## Known issues

If you're experiencing issues with your chatter installation, refer to [Known issues](https://github.com/Chatter-Laravel/core/labels/known-issues). If you couldn't solve the issue, please submit a new ticket.

## Customization

### Configuration

When you published the vendor assets you added a new file inside of your `config` folder which is called `config/chatter.php`. This file contains a bunch of configuration you can use to configure your forums

### Vue components

All the view components used by Chatter are published to your project by the preset instalation. You can make all the changes you need for your project on those.

## Screenshots

<p align="center">
    <img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-demo.gif" alt="Laravel chatter forum demo" style="max-width:600px;"><br>
    <img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum.png" alt="Laravel chatter forum" style="max-width:600px;"></br>
    <img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum-2.png" alt="Laravel chatter forum" style="max-width:600px;"><br>
    <img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum-3.png" alt="Laravel chatter forum" style="max-width:600px;"><br>
    <img src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/laravel-chatter-forum-mobile.png" alt="Laravel chatter forum" style="max-width:600px;">
</p>

