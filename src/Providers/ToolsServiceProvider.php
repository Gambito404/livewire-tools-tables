<?php

namespace Gambito\LivewireTable\Providers;

use Illuminate\Support\ServiceProvider;
use Gambito\LivewireTable\Commands\MakeToolsTableCommand;

class ToolsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/tools.php', 'tools-table');
    }

    public function boot()
    {
        // Cargar vistas con el namespace correcto
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'tools-table');

        if ($this->app->runningInConsole()) {
            // Publicar configuración
            $this->publishes([
                __DIR__.'/../../config/tools.php' => config_path('tools-table.php'),
            ], 'tools-table-config');

            // Publicar todos los estilos CSS (opcional)
            $this->publishes([
                __DIR__.'/../../resources/views/components/styles' => 
                    resource_path('views/vendor/tools-table/styles'),
            ], 'tools-table-styles');

            // Registrar comandos
            $this->commands([
                MakeToolsTableCommand::class,
            ]);
        }
    }
}