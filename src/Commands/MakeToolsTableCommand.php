<?php

namespace Gambito404\ToolsTables\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeToolsTableCommand extends Command
{
    protected $signature = 'make:tools-tables {--model=}';
    protected $description = 'Create a new Livewire Tools Tables component';

    public function handle()
    {
        $model = $this->option('model');

        if (!$model) {
            $this->error('You must specify a model with --model=ModelName');
            return;
        }

        // Si el modelo viene con namespace completo
        if (Str::contains($model, '\\')) {
            $modelClass = ltrim($model, '\\');
            $baseName = class_basename($modelClass);
        } else {
            $modelClass = "App\\Models\\" . Str::studly($model);
            $baseName = Str::studly($model);
        }

        // Nombre del componente = Modelo + "Table"
        $componentName = $baseName . 'Table';
        $namespace = "App\\Livewire\\Tables";
        $path = app_path("Livewire/Tables/{$componentName}.php");

        // Crear carpeta si no existe
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
use Livewire\WithPagination;

class {$componentName} extends DataTable
{
    public function mount(?{$baseName} \$record = null, ?string \$theme = null)
    {
        \$this->record = \$record;
        \$this->mountTheme(\$theme ?? \$this->theme);
        \$this->normalizePerPage();
    }

    protected function columns(): array
    {
        return [
            NumberColumn::make('id', 'Numero'),
            DateColumn::make('created_at', 'Created At'),
            DateColumn::make('updated_at', 'Updated At'),
        ];
    }

    protected function query()
    {
        return {$baseName}::query();
    }

    public function render()
    {
        \$rows = \$this->query()->paginate(\$this->perPageNumber);

        return view('tools-tables::components.datatable.main', [
            'model' => {$baseName}::class,
            'columns' => \$this->columns(),
            'rows' => \$rows,
            'themeCss' => \$this->themeCssPath(),
        ]);
    }
}
PHP;

        if (File::exists($path)) {
            $this->error("Component {$componentName} already exists.");
            return;
        }

        File::put($path, $stub);
        $this->info("✅ Component {$componentName} created for model {$modelClass} at {$path}");

        $livewireTag = 'tables.' . Str::kebab($componentName);
        $this->line('\nTo use it, add the following to your Blade view:');
        $this->info("<livewire:{$livewireTag} />");
    }
}