<?php

Route::namespace('Chatter\Core\Http\Controllers\Api')
    ->prefix('api/chatter')
    ->middleware('api')
    ->group(function () {
        Route::apiResource('category', 'CategoryController');
        Route::apiResource('discussion', 'DiscussionController');
        Route::apiResource('post', 'PostController');
    });
