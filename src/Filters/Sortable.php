<?php

namespace Gambito\LivewireTable\Filters;

class Sortable
{
    public ?string $sortField = null;
    public ?string $sortDirection = null;

    public function sortBy(string $field): void
    {
        if ($this->sortField !== $field) {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        } elseif ($this->sortDirection === 'asc') {
            $this->sortDirection = 'desc';
        } elseif ($this->sortDirection === 'desc') {
            $this->sortField = null;
            $this->sortDirection = null;
        } else {
            $this->sortDirection = 'asc';
        }
    }

    public function apply($query)
    {
        if ($this->sortField && $this->sortDirection) {
            return $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query;
    }
}
