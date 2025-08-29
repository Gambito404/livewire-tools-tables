<?php

namespace Gambito404\ToolsTables\Providers;

use Illuminate\Support\ServiceProvider;
use Gambito404\ToolsTables\Commands\MakeToolsTableCommand;

class ToolsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap del paquete.
     */
    public function boot(): void
    {
        // Registrar vistas con alias "tools-tables::"
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'tools-tables');

        // Publicar configuración
        $this->publishes([
            __DIR__ . '/../../config/tools-tables.php' => config_path('tools-tables.php'),
        ], 'tools-tables-config');

        // Publicar assets (CSS y Tailwind)
        $this->publishes([
            __DIR__ . '/../../resources/assets' => public_path('vendor/tools-tables'),
        ], 'tools-tables-assets');

        // Registrar comandos en consola
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeToolsTableCommand::class,
            ]);
        }
    }

    /**
     * Registrar servicios.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/tools-tables.php',
            'tools-tables'
        );
    }
}