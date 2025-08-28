<?php

namespace Gambito404\ToolsTables\Providers;

use Illuminate\Support\ServiceProviders;
use Gambito404\ToolsTables\Commands\MakeToolsTableCommand;


class ToolsServiceProvider extends ServiceProviders
{
    /**
     * Bootstrap del paquete.
     */
    public function boot(): void
    {
        // Registrar vistas con alias "tools-table::"
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'tools-table');

        // Publicar configuración
        $this->publishes([
            __DIR__ . '/../../config/tools-tables.php' => config_path('tools-tables.php'),
        ], 'tools-table-config');

        // Publicar assets (css y tailwind)
        $this->publishes([
            __DIR__ . '/../../resources/assets' => public_path('vendor/tools-tables'),
        ], 'tools-table-assets');

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