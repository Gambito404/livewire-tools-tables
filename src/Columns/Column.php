<?php

namespace Gambito404\ToolsTables\Columns;

abstract class Column
{
    public string $field;
    public string $title;

    public function __construct(string $field, string $title)
    {
        $this->field = $field;
        $this->title = $title;
    }

    public static function make(string $field, string $title)
    {
        return new static($field, $title);
    }
}