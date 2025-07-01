<div class="tools-table-container {{ $style }}-style">
    @include("tools-table::styles.$style")

    <div class="table-controls">
        <div class="left-controls">
            <label>
                Mostrar
                <select>
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                registros
            </label>

            <input type="text" placeholder="Buscar...">
        </div>

        <div class="right-controls">
            <button>Filtrar</button>
            <button>Exportar</button>
            <button>Reset</button>
        </div>
    </div>

    <!-- Tabla -->
    <table class="tools-data-table">
        <thead>
            <tr>
                @foreach ($columns as $column)
                    @php
                        $sortable = method_exists($column, 'isSortable') && $column->isSortable();
                        $sortKey = method_exists($column, 'getFieldForSorting') ? $column->getFieldForSorting() : $column->field;
                    @endphp
                    <th
                        @if ($sortable)
                            wire:click="sortBy('{{ $sortKey }}')"
                            class="{{ $sortable ? 'sortable' : '' }} {{ $sortField === $sortKey ? 'sorted' : '' }}"
                        @endif
                    >
                        <div class="th-content">
                            <span>{{ $column->title }}</span>
                            @if ($sortable && $sortField === $sortKey)
                                <span class="sort-icon">
                                    {{ $sortDirection === 'asc' ? '▲' : '▼' }}
                                </span>
                            @endif
                        </div>
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                <tr>
                    @foreach ($columns as $column)
                        <td>
                            @if (method_exists($column, 'resolve'))
                                {!! $column->resolve($record) !!}
                            @else
                                {{ $record->{$column->field} }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="pagination">
        <button>&laquo;</button>
        <button class="active">1</button>
        <button>2</button>
        <button>3</button>
        <button>&raquo;</button>
    </div>
</div>
