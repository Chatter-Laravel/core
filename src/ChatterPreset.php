<?php

namespace Chatter\Core;

use Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;
use LaravelFrontendPresets\TailwindCssPreset\TailwindCssPreset;

class ChatterPreset extends Preset
{
    /**
     * Installs Laravel Chatter
     *
     * @param Command $command
     * @return void
     */
    public static function install(Command $command, Composer $composer)
    {
        $command->info('Installing Laravel Chatter...');

        $pluginInstall = $command->option('plugin');

        // Install tailwind presets
        if (! $pluginInstall) {
            TailwindCssPreset::install();
            TailwindCssPreset::installAuth();
        }

        // Publish the service provider and it dependencies
        Artisan::call('vendor:publish', [
            '--provider' => 'Chatter\\Core\\ChatterServiceProvider',
        ]);

        // Update composer autoload
        $command->info('Updating composer autoload');
        $composer->dumpAutoloads();

        // User want to install test data?
        if (!$pluginInstall && ($command->options()["no-interaction"] || $command->confirm('Do you want to install test data? It will remove all the data from your database'))) {
            Artisan::call('migrate:fresh');
            Artisan::call('db:seed', [
                '--class' => 'ChatterTableSeeder',
            ]);
        } else {
            Artisan::call('migrate');
        }

        static::removeNodeModules();
        static::updatePackages();

        if (!$pluginInstall) {
            static::updateJavascript();
            static::copyJsApp();
            static::removeUnused();
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
            "gsap" => "^3.0.1",
            "tiptap" => "^1.26.4",
            "tiptap-extensions" => "^1.28.4",
            "vue" => "^2.6.10",
            "vue-template-compiler" => "^2.6.10",
            "vue-content-loader" => "^0.2.2",
            "vue-router" => "^3.1.3",
            "vueditor" => "^0.3.1",
            "vuex" => "^3.1.2",
            "emoji-mart-vue" => "^2.6.6"
        ], $packages);
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

            if (! $filesystem->isDirectory($directory = resource_path('js'))) {
                $filesystem->makeDirectory($directory, 0755, true);
            }
        });
    }

    protected static function copyJsApp()
    {
        copy(base_path('vendor/chatter-laravel/core/resources/js/main-app.js'), resource_path('js/app.js'));
    }
}
