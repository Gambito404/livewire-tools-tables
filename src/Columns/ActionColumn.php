<?php

namespace Gambito\LivewireTable\Columns;

class ActionColumn extends Column
{
    protected array $buttons = [];

    public static function make(string $title, string $field = ''): static
    {
        return new static($field, $title);
    }

    public function __construct(string $field, string $title)
    {
        parent::__construct($field, $title);
    }

    /**
     * Agrega un botón con contenido HTML completo.
     *
     * @param string $html Contenido del botón (incluye iconos, texto, clases, etc.)
     * @param string|null $route Ruta opcional (por nombre)
     * @param array $params Parámetros para la ruta, por ejemplo: ['id']
     * @return static
     */
    public function button(string $html, ?string $route = null, array $params = []): static
    {
        $this->buttons[] = compact('html', 'route', 'params');
        return $this;
    }

    public function resolve($record): string
    {
        $output = '<div class="flex justify-center items-center space-x-2">';
        foreach ($this->buttons as $btn) {
            $url = $btn['route']
                ? route($btn['route'], collect($btn['params'])->mapWithKeys(fn($key) => [$key => $record->{$key}])->toArray())
                : '#';

            $output .= sprintf(
                '<a href="%s">%s</a>',
                $url,
                $btn['html'] // usamos el HTML completo que ya viene con estilos e íconos
            );
        }
        return $output . '</div>';
    }
}
