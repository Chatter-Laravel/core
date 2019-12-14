<?php

namespace Chatter\Core;

use Event;
use Chatter\Core\Models\Post;
use Chatter\Core\Models\Models;
use Chatter\Core\Models\Category;
use Chatter\Core\Models\Reaction;
use Chatter\Core\Menu\MenuProvider;
use Chatter\Core\Models\Discussion;
use Chatter\Core\Models\PostInterface;
use Chatter\Core\Menu\MenuViewComposer;
use Illuminate\Support\ServiceProvider;
use Chatter\Core\Models\CategoryInterface;
use Chatter\Core\Models\ReactionInterface;
use Chatter\Core\Listeners\EmailSubscriber;
use Chatter\Core\Menu\MenuProviderInterface;
use Chatter\Core\Models\DiscussionInterface;
use Illuminate\Foundation\Console\PresetCommand;

class ChatterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/Lang', 'chatter');
        $this->publishes([
            __DIR__.'/../public/assets' => public_path('vendor/chatter/assets'),
        ], 'chatter_assets');

        $this->publishes([
            __DIR__.'/../config/chatter.php' => config_path('chatter.php'),
        ], 'chatter_config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'chatter_migrations');
        
        $this->publishes([
            __DIR__.'/../database/factories/' => database_path('factories'),
        ], 'chatter_factories');

        $this->publishes([
            __DIR__.'/../database/seeds/' => database_path('seeds'),
        ], 'chatter_seeds');

        $this->publishes([
            __DIR__.'/Helpers' => app_path('Helpers'),
        ], 'chatter_helpers');

        $this->publishes([
            __DIR__.'/Lang' => resource_path('lang/vendor/chatter'),
        ], 'chatter_lang');

        $this->publishes([
            __DIR__.'/../resources/js' => resource_path('js/chatter')
        ], 'chatter_vue_components');

        // include the routes file
        include __DIR__.'/Routes/web.php';
        include __DIR__.'/Routes/api.php';

        $this->bootSubscribers();
        $this->bootInterfaces();
        $this->bootMenu();
        $this->bootCommand();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Register the service provider for the dependency.
         */
        $this->app->register(\Mews\Purifier\PurifierServiceProvider::class);

        /*
         * Create aliases for the dependency.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Purifier', 'Mews\Purifier\Facades\Purifier');

        $viewsDir = __DIR__.'/Views';
        $this->loadViewsFrom($viewsDir, 'chatter');
        $this->publishes([
           $viewsDir => resource_path('views/vendor/chatter'),
        ]);

        $this->registerHelpers();
    }

    private function bootSubscribers(): void
    {
        Event::subscribe(EmailSubscriber::class);
    }

    private function bootInterfaces(): void
    {
        app()->bind(MenuProviderInterface::class, MenuProvider::class);
        app()->bind(DiscussionInterface::class, Discussion::class);
        app()->bind(PostInterface::class, Post::class);
        app()->bind(CategoryInterface::class, Category::class);
        app()->bind(ReactionInterface::class, Reaction::class);
    }

    private function bootMenu(): void
    {
        view()->composer('chatter::*', MenuViewComposer::class);
    }

    private function bootCommand(): void
    {
        PresetCommand::macro('chatter', function ($command) {
            ChatterPreset::install($command);
        });
    }

    private function registerHelpers(): void
    {
        // Load the helpers in app/Http/helpers.php
        if (file_exists($file = app_path('Helpers/ChatterModelsHelper.php'))) {
            require $file;
        }
    }
}
