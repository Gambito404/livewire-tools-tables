<?php

namespace Gambito404\ToolsTable\Columns;

abstract class Column
{
    public string $field;
    public string $label;
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
}
