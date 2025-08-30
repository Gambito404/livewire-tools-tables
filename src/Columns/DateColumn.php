<?php

namespace Gambito404\ToolsTables\Columns;

use Carbon\Carbon;

class DateColumn extends Column
{
    protected string $format = 'd/m/Y';

    public static function make(string $field, string $label): static
    {
        return new static($field, $label);
    }

    public function dateFormat(string $format): static
    {
        $this->format = $format;
        return $this;
    }

    public function getValue($row, ?int $index = null)
    {
        $value = data_get($row, $this->field);

        if (!$value) {
            return '';
        }

        $date = $value instanceof Carbon ? $value : Carbon::parse($value);

        $date->locale('es');

        return $date->translatedFormat($this->format);
    }
}
