<?php

namespace Gambito404\ToolsTables\Http\Livewire\DataTable\Traits;

use Livewire\WithPagination as LivewireWithPagination;

trait WithPagination
{
    use LivewireWithPagination;

    public $perPage = 10;
    public array $perPageOptions = [10, 25, 50, 100];

    public function bootWithPagination(): void
    {
        $this->updatedPerPage(function () {
            $this->resetPage();
        });
    }

    public function normalizePerPage(): void
    {
        if (in_array(session('perPage'), $this->perPageOptions)) {
            $this->perPage = session('perPage');
        }
    }

    public function updatedPerPage($value): void
    {
        session()->put('perPage', $value);
    }

    public function getPerPageNumberProperty(): int
    {
        return (int) $this->perPage;
    }
}
