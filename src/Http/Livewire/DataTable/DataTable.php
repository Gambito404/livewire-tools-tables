<?php

namespace Gambito404\ToolsTables\Http\Livewire\DataTable;

use Gambito404\ToolsTables\Http\Livewire\DataTable\Traits\WithExport;
use Gambito404\ToolsTables\Http\Livewire\DataTable\Traits\WithPagination;
use Gambito404\ToolsTables\Http\Livewire\DataTable\Traits\WithReordering;
use Gambito404\ToolsTables\Http\Livewire\DataTable\Traits\WithSearch;
use Gambito404\ToolsTables\Http\Livewire\DataTable\Traits\WithSorting;
use Livewire\Component;

abstract class DataTable extends Component
{
    use WithPagination;
    use WithSorting;
    use WithSearch;
    use WithReordering;
    use WithExport;

    public $record;
    public string $theme = 'light';

    abstract protected function columns(): array;
    abstract protected function query();

    public function mountTheme(?string $theme = null): void
    {
        $this->theme = $theme ?? config('tools-tables.theme', 'light');
    }

    public function themeCssPath(): string
    {
        $path = 'vendor/tools-tables/css/';
        $themeFile = $this->theme . '.css';
        return asset($path . $themeFile);
    }

    public function render()
    {
        $query = $this->query();
        $query = $this->applySorting($query);
        $query = $this->applySearch($query);
        $rows = $query->paginate($this->perPageNumber);

        $columns = $this->columns();

        $processedRows = $rows->map(function ($row) use ($columns) {
            $processedRow = new \stdClass();
            $processedRow->id = $row->id;
            $processedRow->cells = [];
            foreach ($columns as $column) {
                $processedRow->cells[] = $column->applyFormat($row);
            }
            return $processedRow;
        });

        $viewColumns = array_map(function ($column) {
            return [
                'field' => $column->field,
                'label' => $column->label,
            ];
        }, $columns);

        return view('tools-tables::components.datatable.main', [
            'columns' => $viewColumns,
            'rows' => $rows, // Still needed for pagination
            'processedRows' => $processedRows,
            'themeCss' => $this->themeCssPath(),
        ]);
    }
}
