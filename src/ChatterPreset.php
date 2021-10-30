<?php

namespace Chatter\Core;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Laravel\Ui\Presets\Preset;
use LaravelFrontendPresets\TailwindCssPreset\TailwindCssPreset;

class ChatterPreset extends Preset
{
    /**
     * Installs Laravel Chatter
     *
     * @param Command $command
     * @param Composer $composer
     * @return void
     */
    public static function install(Command $command, Composer $composer)
    {
        $command->info('Installing Laravel Chatter...');

        $pluginInstall = $command->option('plugin');

        // Install tailwind presets
        if (!$pluginInstall) {
            TailwindCssPreset::install();
            TailwindCssPreset::installAuth();
        }

        // Publish the service provider and it's dependencies
        Artisan::call('vendor:publish', [
            '--provider' => 'Chatter\\Core\\ChatterServiceProvider',
        ]);

        // Update composer autoload
        $command->info('Updating composer autoload');
        $composer->dumpAutoloads();

        // User want to install test data?
        if (!$pluginInstall && ($command->options()["no-interaction"] || $command->confirm('Do you want to install test data? It will remove all the data on your database'))) {
            Artisan::call('migrate:fresh');
            Artisan::call('db:seed', [
                '--class' => 'ChatterTableSeeder',
            ]);
        } else {
            Artisan::call('migrate');
        }

        self::installPassport();

        self::removeNodeModules();
        self::updatePackages();

        if (!$pluginInstall) {
            self::updateJavascript();
            self::copyJsApp();
            self::removeUnused();
        }

        exec('npm install && npm run dev');

        $command->info('Chatter installed successfully.');
        $command->info('- Remember to add the "CanDiscuss" trait to your User model');
        $command->info('- Remember to ⭐ the repository https://github.com/Chatter-Laravel/core');
        $command->info('Enjoy Chatter!');
    }

    /**
     * Updates the packages json with the packages we need
     *
     * @return void
     */
    public static function updatePackageArray(array $packages)
    {
        return array_merge([
            "laravel-mix" => "^6.0.37",
            "autoprefixer" => "^9.6",
            "sass" => "^1.43.4",
            "sass-loader" => "^12.3.0",
            "postcss-import" => "^12.0",
            "postcss-nested" => "^4.2",
            "tailwindcss" => "^1.8",
            "lang.js" => "^1.1.14",
            "gsap" => "^3.8.0",
            "tiptap" => "^1.32.2",
            "tiptap-extensions" => "^1.35.2",
            "vue" => "^2.6.14",
            "vue-loader" => "^15.9.8",
            "vue-template-compiler" => "^2.6.14",
            "vue-content-loader" => "^0.2.3",
            "vue-router" => "^3.5.3",
            "vueditor" => "^0.3.1",
            "vuex" => "^3.6.2",
            "emoji-mart-vue" => "^2.6.6"
        ], Arr::except($packages, [
            'bootstrap',
            'bootstrap-sass',
            'popper.js',
            'laravel-mix',
            'jquery',
        ]));
    }

    /**
     * Installs Laravel Passport
     *
     * @return void
     */
    protected static function installPassport(): void
    {
        Artisan::call('passport:install');

        tap(new Filesystem, function ($filesystem) {
            $path = config_path('auth.php');
            $str = $filesystem->get($path);

            $filesystem->put($path, str_replace("'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],", "'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],", $str));
        });
    }

    /**
     * Removes the unused main-app.js template
     *
     * @return void
     */
    protected static function removeUnused()
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->delete(resource_path('js/chatter/main-app.js'));
        });
    }

    /**
     * Deletes the original app.js and copies the template
     *
     * @return void
     */
    protected static function updateJavascript()
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->delete(public_path('js/app.js'));

            # Make directory readable
            if (!$filesystem->isDirectory($directory = resource_path('js'))) {
                $filesystem->makeDirectory($directory, 0755, true);
            }

            # Add .vue() in webpack.mix.js
            $path = 'webpack.mix.js';
            $str = $filesystem->get($path);
            $filesystem->put($path, str_replace("require('autoprefixer'),
  ]);", "require('autoprefixer'),
  ]).vue();", $str));
        });
    }

    protected static function copyJsApp()
    {
        copy(base_path('vendor/chatter-laravel/core/resources/js/main-app.js'), resource_path('js/app.js'));
    }
}
