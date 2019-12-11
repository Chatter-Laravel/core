<p align="center"><img width="300" src="https://raw.githubusercontent.com/chatter-laravel/core/master/public/assets/images/logo.png"></p>

<p align="center">
<img src="https://github.styleci.io/repos/7548986/shield?style=flat" alt="Build status">
</p>

# Chatter - Laravel Forum Package

This is a Vue + Tailwind CSS + Laravel (PWA) forum package. Chatter is a single page application to create forums on Laravel applications with ease. It was tested on Laravel 5.8 without any problem, as per the [roadmap](https://github.com/Chatter-Laravel/core#roadmap) we need to check the compatibility with Laravel 6.

*This package is inspired on the [thedevdojo/chatter](https://github.com/thedevdojo/chatter) package*

## Installation

If you are planning to install Chatter on an already existing project, please check the ChatterPreset class and check which of the instalations steps you need to run, really dependes on what you got.

1. Install [Laravel 5.8](https://laravel.com/docs/5.8#installing-laravel)

2. Include the package in your project

    ```bash
    composer require "chatter-laravel/core:dev-master"
    ```

3. Run the preset command and follow the instructions

    ```bash
    php artisan preset chatter
    ```

The preset command will take care of all that you need to install the forum: migrations, js components, tailwind, composer packages, node packages, etc.

4. Add the CanDiscuss trait to your User model

    ```php
    <?php

    namespace App;

    use Chatter\Core\Traits\CanDiscuss;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class User extends Authenticatable
    {
        use Notifiable, CanDiscuss;
    ```

Now, visit your site.com/forums and you should see your new forum in front of you!

## Roadmap

- [ ] Check compatiblity with Laravel 6
- [ ] Like post and discussions
- [ ] Users profiles
- [ ] Users rewards
- [ ] Tag people on discussions and posts
- [ ] Create tests
- [x] Star this repository

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