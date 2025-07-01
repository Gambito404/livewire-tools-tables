<?php

namespace Gambito\LivewireTable\Columns;

use Closure;

class CustomColumn extends Column
{
    protected string $expression;
    protected Closure $callback;

    public function __construct(string $expression, string $title)
    {
        parent::__construct('', $title);

        // Convierte la expresión para que las variables tengan $
        $this->expression = $this->addDollarToVariables($expression);

        $this->callback = function ($record) {
            $attributes = $record->getAttributes();

            // Crear variables dinámicas para eval
            foreach ($attributes as $key => $value) {
                ${$key} = $value;
            }

            // Validar que todas las variables existan
            preg_match_all('/\$([a-zA-Z_][a-zA-Z0-9_]*)/', $this->expression, $matches);
            foreach ($matches[1] as $var) {
                if (!array_key_exists($var, $attributes)) {
                    return "Campo '$var' no existe";
                }
            }

            try {
                return eval('return (' . $this->expression . ');');
            } catch (\ParseError $e) {
                return 'Error en expresión: ' . $e->getMessage();
            } catch (\Throwable $e) {
                return 'Error: ' . $e->getMessage();
            }
        };
    }

  
    protected function addDollarToVariables(string $expression): string
    {
        // Regex para encontrar palabras que podrían ser campos (no dentro de comillas)
        return preg_replace_callback('/\b([a-zA-Z_][a-zA-Z0-9_]*)\b/', function ($matches) {
            $word = $matches[1];
            // No añadir $ si es palabra reservada, función o cadena (puedes agregar más reglas aquí)
            // Por simplicidad, añade $ a todo
            return '$' . $word;
        }, $expression);
    }

    public static function make(string $expression, string $title): self
    {
        return new self($expression, $title);
    }

    public function render($record): string
    {
        $result = call_user_func($this->callback, $record);
        // Escapar HTML y reemplazar dobles espacios por &nbsp;&nbsp;
        return str_replace('  ', '&nbsp;&nbsp;', e($result));
    }

    public function resolve($record): string
    {
        return $this->render($record);
    }

    public function getFieldForSorting(): string
    {
        // Extrae el primer campo (sin $)
        preg_match('/\$([a-zA-Z_]+)/', $this->expression, $matches);
        return $matches[1] ?? '';
    }
}
