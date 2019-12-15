<?php

namespace Chatter\Core;

use Artisan;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\PresetCommand;
use LaravelFrontendPresets\TailwindCssPreset\TailwindCssPreset;

class ChatterInstallCommand extends PresetCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chatter:install {--plugin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the Chatter package';

    /**
     * Installs Laravel Chatter
     *
     * @param Command $command
     * @return void
     */
    public function handle()
    {
        ChatterPreset::install($this);
    }
}
