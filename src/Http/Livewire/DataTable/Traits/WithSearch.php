<?php

namespace Gambito404\ToolsTables\Http\Livewire\DataTable\Traits;

trait WithSearch
{
    public $search = '';

    public function bootWithSearch()
    {
        $this->updatedSearch(function () {
            $this->resetPage();
        });
    }

    protected function applySearch($query)
    {
        if ($this->search) {
            $query->where(function ($q) {
                foreach ($this->columns() as $column) {
                    if ($column->isSearchable()) {
                        $q->orWhere($column->field, 'like', '%' . $this->search . '%');
                    }
                }
            });
        }

        return $query;
    }
}
