<?php

use Illuminate\Http\Request;
use Chatter\Core\Models\Post;
use Chatter\Core\Mail\PostUpdated;
use Chatter\Core\Events\PostEvents;
use Chatter\Core\Models\Discussion;
use Chatter\Core\Events\AfterNewPost;

Route::namespace('Chatter\Core\Http\Controllers')
    ->name('chatter.')
    ->middleware('web')
    ->group(function () {
        Route::get('/'.config('chatter.routes.home'), 'IndexController@index')->name('home');
        Route::get('/'.config('chatter.routes.home').'/'.config('chatter.routes.category').'/{category}', 'IndexController@index')->name('category');
        Route::get('/'.config('chatter.routes.home').'/'.config('chatter.routes.discussion').'/{category}/{title}', 'IndexController@index')->name('discussion');

        Route::get('/'.config('chatter.routes.home').'.atom', 'AtomController@index')->name('atom');
    });
