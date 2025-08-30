<?php

namespace Gambito404\ToolsTables\Columns;

class DateColumn extends Column
{
    public ?string $format = null;

    public function format(string $format): self
    {
        $this->format = $format;
        return $this;
    }

    public function getValue($row, ?int $index = null)
    {
        $value = parent::getValue($row, $index);
        if ($value && $this->format) {
            setlocale(LC_TIME, 'es_ES.UTF-8'); // días y meses en español
            $date = strtotime($value);
            return strftime($this->format, $date);
        }
        return $value;
    }
}
