<?php

namespace Gambito404\ToolsTables\Columns;

class DateColumn extends Column
{
    public string $dateFormat = 'Y-m-d H:i:s';

    public function dateFormat(string $format): self
    {
        $this->dateFormat = $format;
        return $this;
    }
}