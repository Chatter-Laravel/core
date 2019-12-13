<?php

namespace Chatter\Core\Tests;

use Illuminate\Log\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Chatter\Core\Models\CategoryInterface;
use Chatter\Core\Models\DiscussionInterface;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelFrontendPresets\TailwindCssPreset\TailwindCssPreset;

abstract class TestCase extends BaseTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('vendor:publish', [
            '--provider' => \Chatter\Core\ChatterServiceProvider::class,
        ])->run();

        $this->loadLaravelMigrations(['--database' => 'testbench']);
        $this->artisan('migrate:fresh', [
            '--database' => 'testbench'
            ])->run();

        dd(\DB::select("
        SELECT 
            name
        FROM 
            sqlite_master 
        WHERE 
            type ='table' AND 
            name NOT LIKE 'sqlite_%'"));

        // $logger = $this->app[Logger::class];
        // $handlers = $logger->getHandlers();
        // dd($handlers);
        // 
        
        $uses = array_flip(class_uses_recursive(static::class));
        if (isset($uses[WithUser::class])) {
            $this->setUpUser();
        }
    }

    /**
     * Defines the service provider
     *
     * @param Application $app
     * @return void
     */
    protected function getPackageProviders($app)
    {
        return [ \Chatter\Core\ChatterServiceProvider::class ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.debug', true);
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => ''
        ]);

        // $app->configureMonologUsing(function ($monolog) {
        //     $path = __DIR__ . "/logs/laravel.log";
        //     $handler = $handler = new StreamHandler($path, 'debug');
        //     $handler->setFormatter(tap(new LineFormatter(null, null, true, true), function ($formatter) {
        //         /** @var LineFormatter $formatter */
        //         $formatter->includeStacktraces();
        //     }));
        //     /** @var \Monolog\Logger $monolog */
        //     $monolog->pushHandler($handler);
        // });
    }

    /**
     * Get application timezone.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return string|null
     */
    protected function getApplicationTimezone($app)
    {
        return 'Europe/London';
    }
}
