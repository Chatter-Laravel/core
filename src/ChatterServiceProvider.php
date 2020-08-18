<?php

namespace Chatter\Core;

use Event;
use Chatter\Core\Models\Post;
use Laravel\Passport\Passport;
use Chatter\Core\Models\Models;
use Chatter\Core\Models\Category;
use Chatter\Core\Models\Reaction;
use Chatter\Core\Menu\MenuProvider;
use Chatter\Core\Models\Discussion;
use Chatter\Core\Models\PostInterface;
use Illuminate\Foundation\AliasLoader;
use Chatter\Core\Menu\MenuViewComposer;
use Illuminate\Support\ServiceProvider;
use Chatter\Core\Models\CategoryInterface;
use Chatter\Core\Models\ReactionInterface;
use Chatter\Core\Listeners\EmailSubscriber;
use Chatter\Core\Menu\MenuProviderInterface;
use Chatter\Core\Models\DiscussionInterface;
use Laravel\Ui\UiCommand;

class ChatterServiceProvider extends ServiceProvider
{
    const BIND_PREFIX = 'chatter.';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'chatter');
        $this->publishes([
            __DIR__.'/Views' => resource_path('views/vendor/chatter'),
        ], 'chatter_views');

        $this->loadTranslationsFrom(__DIR__.'/Lang', 'chatter');
        $this->publishes([
            __DIR__.'/Lang' => resource_path('lang/vendor/chatter'),
        ], 'chatter_lang');

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
            __DIR__.'/../resources/js' => resource_path('js/chatter')
        ], 'chatter_vue_components');

        // include the routes file
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');

        $this->bootSubscribers();
        $this->bootInterfaces();
        $this->bootMenu();
        $this->bootCommand();
        $this->bootPassport();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPurifier();
        $this->registerHelpers();
    }

    protected function bootSubscribers(): void
    {
        Event::subscribe(EmailSubscriber::class);
    }

    protected function bootInterfaces(): void
    {
        app()->bind(MenuProviderInterface::class, MenuProvider::class);
        app()->bind(DiscussionInterface::class, Discussion::class);
        app()->bind(PostInterface::class, Post::class);
        app()->bind(CategoryInterface::class, Category::class);
        app()->bind(ReactionInterface::class, Reaction::class);
    }

    protected function bootMenu(): void
    {
        view()->composer('chatter::*', MenuViewComposer::class);
    }

    protected function bootCommand(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ChatterInstallCommand::class
            ]);
        }
    }

    protected function registerHelpers(): void
    {
        // Load the helpers in app/Http/helpers.php
        if (file_exists($file = app_path('Helpers/ChatterModelsHelper.php'))) {
            require $file;
        }
    }

    protected function registerPurifier(): void
    {
        /*
         * Register the service provider for the dependency.
         */
        $this->app->register(\Mews\Purifier\PurifierServiceProvider::class);

        /*
         * Create aliases for the dependency.
         */
        AliasLoader::getInstance()->alias('Purifier', 'Mews\Purifier\Facades\Purifier');
    }
    
    protected function bootPassport(): void
    {
        Passport::routes();
    }
}
