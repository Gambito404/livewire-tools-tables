<?php

namespace Gambito404\ToolsTables\Columns;

class NumberColumn extends Column
{
    public ?int $decimals = null;
    public ?string $prefix = null;
    public ?string $suffix = null;

    public function decimals(int $decimals): self
    {
        $this->decimals = $decimals;
        return $this;
    }

    public function prefix(string $prefix): self
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function suffix(string $suffix): self
    {
        $this->suffix = $suffix;
        return $this;
    }

    public function getValue($row, ?int $index = null)
    {
        $value = parent::getValue($row, $index);
        if (is_numeric($value) && $this->decimals !== null) {
            $value = number_format((float)$value, $this->decimals, '.', '');
        }
        return ($this->prefix ?? '') . $value . ($this->suffix ?? '');
    }
}
