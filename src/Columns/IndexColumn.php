<?php

namespace Gambito404\ToolsTables\Columns;

class IndexColumn extends Column
{
    protected const INTERNAL_FIELD = '__index__';

    public static function make(string $field = self::INTERNAL_FIELD, string $label = 'Nro'): static
    {
        // ignoramos el $field y siempre usamos el interno
        return new static(self::INTERNAL_FIELD, $label);
    }

    public function getValue($row, ?int $index = null)
    {
        return ($index !== null) ? $index + 1 : '';
    }
}
