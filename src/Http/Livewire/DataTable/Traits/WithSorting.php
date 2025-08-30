<?php

namespace Gambito404\ToolsTables\Http\Livewire\DataTable\Traits;

trait WithSorting
{
    public $sortColumn = 'id';
    public $sortDirection = 'asc';

    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    protected function applySorting($query)
    {
        if ($this->sortColumn) {
            return $query->orderBy($this->sortColumn, $this->sortDirection);
        }

        return $query;
    }
}
