<?php

namespace Gambito404\ToolsTable\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeToolsTableCommand extends Command
{
    protected $signature = 'make:tools-table {name} {--model=}';
    protected $description = 'Create a new Livewire Tools Table component';

    public function handle()
    {
        $name = $this->argument('name');
        $model = $this->option('model');

        if (!$model) {
            $this->error('You must specify a model with --model=ModelName');
            return;
        }

        $modelClass = Str::studly($model);
        $componentName = Str::studly($name);
        $namespace = "App\\Livewire\\Table";
        $path = app_path("Livewire/Table/{$componentName}.php");

        if (!File::isDirectory(app_path('Livewire/Table'))) {
            File::makeDirectory(app_path('Livewire/Table'), 0755, true);
        }

        $stub = <<<PHP
<?php

namespace {$namespace};

use Gambito404\ToolsTable\Http\Livewire\DataTable\DataTable;
use App\Models\{$modelClass};
use Gambito404\ToolsTable\Columns\NumberColumn;
use Gambito404\ToolsTable\Columns\DateColumn;
use Livewire\WithPagination;

class {$componentName} extends DataTable
{
    //public {$modelClass} \$record;
    //public string \$theme = 'light';

    //public array \$perPage = [5];

    public function mount(?{$modelClass} \$record = null, ?string \$theme = null)
    {
        $this->record = $record;
        $this->mountTheme($theme ?? $this->theme);
        $this->normalizePerPage();
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
        return {$modelClass}::query();
    }

    public function render()
    {
        $rows = $this->query()->paginate($this->perPageNumber);

        return view('tools-table::components.datatable.main', [
            'model' => {$modelClass}::class,
            'columns' => $this->columns(),
            'rows' => $rows,
            'themeCss' => $this->themeCssPath(),
        ]);
    }
}
PHP;

        if (File::exists($path)) {
            $this->error("Component {$componentName} already exists.");
            return;
        }

        File::put($path, $stub);
        $this->info("Component {$componentName} created for model {$modelClass} at {$path}");
    }
}