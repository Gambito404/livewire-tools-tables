<table class="tools-table">
    <thead>
        <tr>
            @foreach($columns as $column)
                <th wire:click="sortBy('{{ $column['field'] }}')">
                    <span>{{ $column['label'] }}</span>
                    @if($sortColumn === $column['field'])
                        <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                    @endif
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse($processedRows as $row)
            <tr>
                                @foreach($row->cells as $cell)
                    <td>{!! $cell !!}</td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($columns) }}">No results found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
