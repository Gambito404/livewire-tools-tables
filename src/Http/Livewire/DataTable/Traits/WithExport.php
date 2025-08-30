<?php

namespace Gambito404\ToolsTables\Http\Livewire\DataTable\Traits;

use Gambito404\ToolsTables\Support\Exporters\CsvExporter;
use Gambito404\ToolsTables\Support\Exporters\ExcelExporter;
use Gambito404\ToolsTables\Support\Exporters\JsonExporter;
use Gambito404\ToolsTables\Support\Exporters\PdfExporter;

trait WithExport
{
    public $exportFormat = 'csv';
    public array $exportOptions = ['csv', 'xlsx', 'json', 'pdf'];

    public function export()
    {
        $exporter = $this->getExporter();
        $data = $this->query()->get();
        $columns = $this->columns();

        return $exporter->export($data, $columns);
    }

    protected function getExporter()
    {
        return match ($this->exportFormat) {
            'csv' => new CsvExporter(),
            'xlsx' => new ExcelExporter(),
            'json' => new JsonExporter(),
            'pdf' => new PdfExporter(),
            default => new CsvExporter(),
        };
    }
}
