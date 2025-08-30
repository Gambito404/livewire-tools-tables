<?php

namespace Gambito404\ToolsTables\Columns;

abstract class Column
{
    public string $field;
    public string $label;
    public bool $hidden = false;
    public ?\Closure $formatCallback = null;

    public function __construct(string $field, string $label)
    {
        $this->field = $field;
        $this->label = $label;
    }

    public static function make(string $field, string $label): static
    {
        return new static($field, $label);
    }

    public function format(\Closure $callback): self
    {
        $this->formatCallback = $callback;
        return $this;
    }

    public function hide(): self
    {
        $this->hidden = true;
        return $this;
    }

    public function getValue($row, ?int $index = null)
    {
        $value = $row->{$this->field} ?? null;
        if ($this->formatCallback) {
            return $this->formatCallback->__invoke($row, $index);
        }
        return $value;
    }
}
