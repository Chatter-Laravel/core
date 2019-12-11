<?php

return [

    'title' => 'Forum',
    'subtitle' => 'The community forums is a place to discuss anything development/design related. Remember to be nice and have fun....',
    'color' => '#2d3748',

    /*
    |--------------------------------------------------------------------------
    | Forum Routes
    |--------------------------------------------------------------------------
    |
    | Here you can specify the specific routes for the different sections of
    | your forum.
    |
    */
    'routes' => [
        'home'       => 'forums',
        'discussion' => 'discussion',
        'category'   => 'category'
    ],

   /*
    |--------------------------------------------------------------------------
    | Headline logo
    |--------------------------------------------------------------------------
    |
    | Specify the url for your logo. If left empty the headline and
    | description from the language files will be used.
    |
    |   *headline_logo*: If this is set an image will be used on the forum home
    |       instead of text. Specify the relative path to the image here.
    |
    */

    'headline_logo' => '/vendor/chatter-laravel/core/assets/images/logo-light.png',

    /*
    |--------------------------------------------------------------------------
    | The master layout file for your site
    |--------------------------------------------------------------------------
    |
    | By default Laravel's master file is the layouts.app file, but if your
    | master layout file is somewhere else, you can specify it below
    |
    */

    'master_file_extend' => 'layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Information about the forum User
    |--------------------------------------------------------------------------
    |
    | Your forum needs to know specific information about your user in order
    | to confirm that they are logged in and to link to their profile.
    |
    |   *namespace*: This is the user namespace for your User Model.
    |
    |   *database_field_with_user_name*: This is the database field that
    |       is used for the users 'Name', could be 'username', 'first_name'.
    |       This will appear next to the user's avatar in discussions
    |
    |   *relative_url_to_profile*: Users may want to click on another users
    |       image to view their profile. If a users profile page is at
    |       /profile/{username} you will add '/profile/{username}' or
    |       if it is /profile/{id}, you will specify '/profile/{id}'. You are
    |       only able to specify 1 url parameter.
    |       Tip: leave this blank and no link will be generated
    |
    |   *relative_url_to_image_assets*: This is where your image assets are
    |       located. This will be used with the 'avatar_image_database_field'
    |       so if your image assets are located at '/uploads/images/' and
    |       the 'avatar_image_database_field' contains 'avatars/johndoe.jpg'
    |       the full image url will be '/uploads/images/avatar/johndoe.jpg'
    |       Tip: leave this blank if you have absolute url's for images
    |       stored in the database.
    |
    |   *avatar_image_database_field*: This is the database field that
    |       contains the logged in user avatar image. This field will
    |       be inside of the 'users' database table. Tip: leave this
    |       empty if you want to keep the default color circles with
    |       users first initial.
    |
    */

    'user' => [
        'namespace'                     => 'App\User',
        'database_field_with_user_name' => 'name',
        'relative_url_to_profile'       => '',
        'relative_url_to_image_assets'  => '',
        'avatar_image_database_field'   => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | A Few security measures to prevent spam on your forum
    |--------------------------------------------------------------------------
    |
    | Here are a few configurations that you can add to your forum to prevent
    | possible spammers or bots.
    |
    |   *time_between_posts*: In seconds, the time a user must wait before
    |       being allowed to add more content. 0 to disable it
    |
    */

    'security' => [
        'time_between_posts' => 30, // In seconds or 0 to disable it
    ],

    /*
    |--------------------------------------------------------------------------
    | Default orderby
    |--------------------------------------------------------------------------
    |
    | This determines how the Discussions will be ordered on the home screen
    |
    */

    'order_by' => [
        'posts' => [
            'order' => 'created_at',
            'by' => 'ASC',
        ],
        'discussions' => [
            'order' => 'last_reply_at',
            'by' => 'DESC',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Notification Settings
    |--------------------------------------------------------------------------
    |
    | The following are settings that you can use to modify the email settings
    |   - enabled (if you would like to enable or disable email notifications)
    |   - view (the email view sent) $discussion var is passed to view
    |   -
    |
    */
    'email' => [
        'enabled' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Settings
    |--------------------------------------------------------------------------
    |
    | These are the pagination settings for your forum. Specify how many number
    | of results you want to show per page.
    |
    */

    'paginate' => [
        'discussions' => 24,
        'posts' => 10
    ],

];
