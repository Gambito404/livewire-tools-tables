<?php

namespace Gambito\LivewireTable\Http\Livewire;

use Livewire\Component;
use Gambito\LivewireTable\Filters\Sortable;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseTable extends Component
{
    public ?string $sortField = null;
    public ?string $sortDirection = null;

    public string $template;
    public string $style;

    protected Sortable $sortable;

    public function mount()
    {
        $this->sortable = new Sortable();

        // Template fijo
        $this->template = 'tools-table::templates.base';

        // Estilo: prioridad al definido por el componente, luego config/env, por último 'ligth'
        $this->style = $this->style ?? config('livewire-table.styles', env('LIVEWIRE_TABLE_STYLE', 'ligth'));
    }

    public function sortBy(string $field)
    {
        if (!isset($this->sortable)) {
            $this->sortable = new Sortable();
        }

        $this->sortable->sortField = $this->sortField;
        $this->sortable->sortDirection = $this->sortDirection;

        $this->sortable->sortBy($field);

        $this->sortField = $this->sortable->sortField;
        $this->sortDirection = $this->sortable->sortDirection;
    }

    protected function applySorting(Builder $query): Builder
    {
        if (!isset($this->sortable)) {
            $this->sortable = new Sortable();
        }

        $this->sortable->sortField = $this->sortField;
        $this->sortable->sortDirection = $this->sortDirection;

        return $this->sortable->apply($query);
    }

    public function getSortedRecordsProperty()
    {
        $query = $this->getRecords();

        if (!$query instanceof Builder) {
            throw new \Exception('El método getRecords debe devolver un Builder.');
        }

        return $this->applySorting($query)->get();
    }

    public function render()
    {
        // Filtrar columnas que no están ocultas (hidden == false)
        $columns = collect($this->columns())->filter(function ($column) {
            // Si la propiedad hidden no está definida, asumimos visible (false)
            if (method_exists($column, 'isHidden')) {
                return !$column->isHidden();
            }
            return true;
        })->values()->all();

        return view($this->template, [
            'columns' => $columns,
            'records' => $this->sortedRecords,
            'sortField' => $this->sortField,
            'sortDirection' => $this->sortDirection,
            'style' => $this->style,
        ]);
    }

    abstract protected function getRecords(): Builder;
    abstract protected function columns(): array;
}
