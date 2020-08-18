<?php

namespace Chatter\Core;

use Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Laravel\Ui\UiCommand;
use LaravelFrontendPresets\TailwindCssPreset\TailwindCssPreset;

class ChatterInstallCommand extends UiCommand
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
     * Composer instance
     *
     * @var Composer
     */
    protected $composer;

    /**
     * Create a new console command instance.
     *
     * @return void
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }
    /**
     * Installs Laravel Chatter
     *
     * @param Command $command
     * @return void
     */
    public function handle()
    {
        ChatterPreset::install($this, $this->composer);
    }
}
