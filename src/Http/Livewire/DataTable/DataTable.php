<?php

namespace Gambito404\ToolsTables\Http\Livewire\DataTable;

use Livewire\Component;

abstract class DataTable extends Component
{
    public string $title = 'Tabla de datos';
    public string $theme; // 'light', 'dark', 'minimal', 'orange'

    abstract protected function columns(): array;

    abstract protected function query();

    public function mount()
    {
        // Si no se definió un tema en el componente, usar el tema por defecto del config
        $this->theme = $this->theme ?? config('tools-tables.theme', 'light');
    }

    public function render()
    {
        $rows = $this->query()->get();
        $columns = $this->columns();

        return view('tools-tables::components.datatable.main', [
            'columns' => $columns,
            'rows'    => $rows,
            'title'   => $this->title,
            'theme'   => $this->theme, // solo el nombre, la vista se encarga de asset()
        ]);
    }
}
