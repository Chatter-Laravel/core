<?php

/**
 * Helpers.
 */

// Route helper.
$route = function ($accessor, $default = '') {
    return $this->app->config->get('chatter.routes.'.$accessor, $default);
};

// Middleware helper.
$middleware = function ($accessor, $default = []) {
    return $this->app->config->get('chatter.middleware.'.$accessor, $default);
};

// Authentication middleware helper.
$authMiddleware = function ($accessor) use ($middleware) {
    return array_unique(
        array_merge((array) $middleware($accessor), ['auth'])
    );
};

Route::namespace('Chatter\Core\Http\Controllers')
    ->name('chatter.')
    ->middleware('web')
    ->group(function () {
        Route::get('/'.config('chatter.routes.home'), 'IndexController@index')->name('home');
        Route::get('/'.config('chatter.routes.home').'/'.config('chatter.routes.category').'/{category}', 'IndexController@index')->name('category');
        Route::get('/'.config('chatter.routes.home').'/'.config('chatter.routes.discussion').'/{category}/{title}', 'IndexController@index')->name('discussion');

        Route::get('/'.config('chatter.routes.home').'.atom', 'AtomController@index')->name('atom');
    });

