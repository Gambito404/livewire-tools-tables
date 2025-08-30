<?php

namespace Gambito404\ToolsTables\Columns;

abstract class Column
{
    public string $field;
    public string $label;
    public bool $searchable = false;

    /** @var \Closure|null */
    protected $formatCallback = null;
    
    // Nueva propiedad para métodos nombrados
    protected ?string $formatMethod = null;

    public function __construct(string $field, string $label)
    {
        $this->field = $field;
        $this->label = $label;
    }

    public static function make(string $field, string $label): static
    {
        return new static($field, $label);
    }

    // Opción 1: Closure (para máxima flexibilidad)
    public function format(\Closure $callback): self
    {
        $this->formatCallback = $callback;
        return $this;
    }

    // Opción 2: Método nombrado (para serialización)
    public function formatUsing(string $methodName): self
    {
        $this->formatMethod = $methodName;
        return $this;
    }

    public function hasFormat(): bool
    {
        return $this->formatCallback !== null || $this->formatMethod !== null;
    }

    public function applyFormat(mixed $row): mixed
    {
        if ($this->formatCallback) {
            return call_user_func($this->formatCallback, $row);
        }
        
        if ($this->formatMethod) {
            return call_user_func([$row, $this->formatMethod]);
        }
        
        return $row->{$this->field};
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

    /**
     * Excluir closures de la serialización
     */
    public function __sleep()
    {
        return ['field', 'label', 'searchable', 'formatMethod'];
    }

    /**
     * Reconstruir después de la deserialización
     */
    public function __wakeup()
    {
        // Solo perdemos los closures, los métodos nombrados se mantienen
        $this->formatCallback = null;
    }
}