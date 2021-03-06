<?php

namespace SequelONE\SongsCRUD;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class SongsCRUDServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Where the route file lives, both inside the package and in the app (if overwritten).
     *
     * @var string
     */
    public $routeFilePath = '/routes/backpack/songscrud.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // publish migrations
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations')], 'migrations');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'songs-crud');

        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('resources/lang/vendor/songs-crud'),
        ], 'SongsCRUD-lang');

        $this->publishes([
            __DIR__ . '/../resources/views/crud/fields' => base_path('resources/views/vendor/backpack/crud/fields'),
        ], 'SongsCRUD-views');

        $this->publishes([
            __DIR__.'/../config/songscrud.php' => base_path('config/songscrud.php'),
        ], 'SongsCRUD-config');

        $this->publishes([
            __DIR__.'/../public' => base_path('public/vendor/songs-crud'),
        ], 'SongsCRUD-public');

        if ( $this->app->runningInConsole() ) {
            $this->commands([
                app\Console\Type::class,
                app\Console\Genre::class,
                app\Console\Clear::class
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // register its dependencies
        $this->app->register(\Cviebrock\EloquentSluggable\ServiceProvider::class);

        $this->mergeConfigFrom(__DIR__.'/../config/songscrud.php', 'songscrud');

        // setup the routes
        $this->setupRoutes($this->app->router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }
}
