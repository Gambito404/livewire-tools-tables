<?php

namespace Gambito\LivewireTable\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MakeToolsTableCommand extends Command
{
    protected $signature = 'make:tools-table {--model=}';
    protected $description = 'Crea un componente Livewire para usar con LivewireTable';

    public function handle()
    {
        $model = $this->option('model');

        if (! $model) {
            $this->error('❌ Debes especificar el modelo con --model=NombreModelo');
            return;
        }

        $name = class_basename($model);
        $modelNamespace = "App\\Models\\$name";

        if (! class_exists($modelNamespace)) {
            $this->error("❌ El modelo [$modelNamespace] no existe.");
            return;
        }

        $componentName = $name . 'ToolsTable';
        $namespace = 'App\\Livewire';
        $path = app_path("Livewire/{$componentName}.php");

        if (file_exists($path)) {
            $this->error('❌ El componente ya existe.');
            return;
        }

        $columns = [];

        try {
            $table = (new $modelNamespace)->getTable();
            $fields = Schema::getColumnListing($table);

            foreach ($fields as $field) {
                $title = Str::title(str_replace('_', ' ', $field));
                $columns[] = "            Column::make('$field', '$title'),";
            }

        } catch (\Throwable $e) {
            $this->error("❌ No se pudo leer los campos del modelo. ¿Tiene migración y tabla en la BD?");
            return;
        }

        $columnsCode = implode("\n", $columns);

        $stub = <<<PHP
<?php

namespace $namespace;

use $modelNamespace;
use Gambito\\LivewireTable\\Columns\\Column;
use Gambito\\LivewireTable\\Http\\Livewire\\BaseTable;
use Illuminate\\Database\\Eloquent\\Builder;

class $componentName extends BaseTable
{
    protected function columns(): array
    {
        return [
$columnsCode
        ];
    }

    protected function getRecords(): Builder
    {
        return $name::query();
    }
}

PHP;

        file_put_contents($path, $stub);

        $this->info("✅ Componente [$componentName] creado exitosamente.");
        $this->line("📁 Ubicación: $path");
        $this->line("💡 Puedes usarlo en Blade con: <livewire:" . Str::kebab($componentName) . " />");
        $this->line("👍 ¡Listo para usar con LivewireTable!");
    }
}
