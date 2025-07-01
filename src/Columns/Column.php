<?php

namespace Gambito\LivewireTable\Columns;

class Column
{
    public string $field;
    public string $title;

    protected bool $sortable = false;

    protected bool $hidden = false;

    public function __construct(string $field, string $title)
    {
        $this->field = $field;
        $this->title = $title;
    }

    public static function make(string $field, string $title): self
    {
        return new self($field, $title);
    }

    public function sortable(bool $value = true): self
    {
        $this->sortable = $value;
        return $this;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * Establece si la columna debe estar oculta.
     * Recibe directamente un booleano (resultado de cualquier condición)
     *
     * @param bool $hidden
     * @return $this
     */
    public function hidden(bool $hidden): self
    {
        $this->hidden = $hidden;
        return $this;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }
}
