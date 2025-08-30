<?php

namespace Gambito404\ToolsTables\Columns;

abstract class Column
{
    public string $field;
    public string $label;
    public bool $searchable = false;

    /** @var \Closure|null */
    protected $formatCallback = null; // 👈 ya no pública

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

    public function hasFormatCallback(): bool
    {
        return $this->formatCallback !== null;
    }

    public function applyFormat(mixed $row): mixed
    {
        return $this->formatCallback
            ? call_user_func($this->formatCallback, $row)
            : $row->{$this->field};
    }

    public function searchable(): self
    {
        $this->searchable = true;
        return $this;
    }

    public function isSearchable(): bool
    {
        return $this->searchable;
    }
}
