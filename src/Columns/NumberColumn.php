<?php

namespace Gambito404\ToolsTable\Columns;

class NumberColumn extends Column
{
    public bool $displayAsRowNumber = false;
    public ?array $numberFormat = null;

    public function displayAsRowNumber(): self
    {
        $this->displayAsRowNumber = true;
        return $this;
    }

    public function numberFormat(int $decimals = 0, string $decimalSeparator = '.', string $thousandsSeparator = ','): self
    {
        $this->numberFormat = [
            'decimals' => $decimals,
            'decimal_separator' => $decimalSeparator,
            'thousands_separator' => $thousandsSeparator,
        ];
        return $this;
    }
}