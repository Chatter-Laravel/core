<?php

Route::namespace('Chatter\Core\Http\Controllers\Api')
    ->name('chatter.api.')
    ->prefix('api/chatter')
    ->middleware('api')
    ->group(function () {
        Route::apiResource('category', 'CategoryController');
        Route::apiResource('discussion', 'DiscussionController');
        Route::apiResource('post', 'PostController');

        Route::post('post/react/{id}', 'ReactionController@toggle')->name('post.reaction');
    });
