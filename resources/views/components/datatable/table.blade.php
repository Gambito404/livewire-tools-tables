<table>
    <thead>
        <tr>
            @foreach($columns as $column)
                @unless($column->hidden)
                    <th>{{ $column->label }}</th>
                @endunless
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $index => $row)
            <tr>
                @foreach($columns as $column)
                    @unless($column->hidden)
                        <td>{{ $column->getValue($row, $index) }}</td>
                    @endunless
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

