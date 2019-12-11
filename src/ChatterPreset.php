<?php

namespace Chatter\Core;

use Artisan;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;
use LaravelFrontendPresets\TailwindCssPreset\TailwindCssPreset;

class ChatterPreset extends Preset
{
    public static function install(Command $command)
    {
        $command->info('Installing Laravel Chatter...');

        // Install tailwind presets
        TailwindCssPreset::install();
        TailwindCssPreset::installAuth();

        // Publish the service provider and it dependencies
        Artisan::call('vendor:publish', [
            '--provider' => 'Chatter\Core\ChatterServiceProvider',
        ]);

        // Update composer autoload
        exec('composer dump-autoload');

        // User want to install test data?
        if ($command->confirm('Do you want to install test data? It will remove all the data from your database')) {
            Artisan::call('migrate:refresh');
            Artisan::call('db:seed', [
                '--class' => 'ChatterTableSeeder',
            ]);
        } else {
            Artisan::call('migrate');
        }

        static::updateJavascript();
        static::removeNodeModules();
        static::updatePackages();
        exec('npm install && npm run dev');

        $command->info('Chatter installed successfully.');
        $command->info('- Remember to add the CanDiscuss trait to your User model');
        $command->info('- Remember to ⭐ the repository https://github.com/Chatter-Laravel/core');
    }

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
            "vuex" => "^3.1.2"
        ], $packages);
    }

    protected static function updateJavascript()
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->delete(public_path('js/app.js'));

            if (! $filesystem->isDirectory($directory = resource_path('js'))) {
                $filesystem->makeDirectory($directory, 0755, true);
            }
        });

        copy(base_path('vendor/chatter-laravel/core/resources/js/main-app.js'), resource_path('js/app.js'));
    }
}
