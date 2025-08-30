<?php

namespace Gambito404\ToolsTables\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeToolsTableCommand extends Command
{
    protected $signature = 'make:tools-tables {--model=}';
    protected $description = 'Crear un componente Livewire de Tools Tables';

    public function handle()
    {
        $model = $this->option('model');

        if (!$model) {
            $this->error('Debes especificar un modelo con --model=NombreDelModelo');
            return;
        }

        // Determinar clase completa y nombre base
        if (Str::contains($model, '\\')) {
            $modelClass = ltrim($model, '\\');
            $baseName = class_basename($modelClass);
        } else {
            $modelClass = "App\\Models\\" . Str::studly($model);
            $baseName = Str::studly($model);
        }

        $componentName = $baseName . 'Table';
        $namespace = "App\\Livewire\\Tables";
        $path = app_path("Livewire/Tables/{$componentName}.php");

        if (!File::isDirectory(app_path('Livewire/Tables'))) {
            File::makeDirectory(app_path('Livewire/Tables'), 0755, true);
        }

        $stub = <<<PHP
<?php

namespace {$namespace};

use Gambito404\ToolsTables\Http\Livewire\DataTable\DataTable;
use {$modelClass};
use Gambito404\ToolsTables\Columns\NumberColumn;
use Gambito404\ToolsTables\Columns\DateColumn;

class {$componentName} extends DataTable
{
    protected function columns(): array
    {
        return [
            NumberColumn::make('id', 'Número'),
            DateColumn::make('created_at', 'Creado'),
            DateColumn::make('updated_at', 'Actualizado'),
        ];
    }

    protected function query()
    {
        return {$baseName}::query();
    }

    public function render()
    {
        \$rows = \$this->query()->get();

        return view('tools-tables::components.datatable.main', [
            'model' => {$baseName}::class,
            'columns' => \$this->columns(),
            'rows' => \$rows,
        ]);
    }
}
PHP;

        if (File::exists($path)) {
            $this->error("El componente {$componentName} ya existe.");
            return;
        }

        File::put($path, $stub);
        $this->info("✅ Componente {$componentName} creado para el modelo {$modelClass} en {$path}");

        $livewireTag = 'tables.' . Str::kebab($componentName);
        $this->info("Para usarlo, agrega en tu Blade: <livewire:{$livewireTag} />");
    }
}