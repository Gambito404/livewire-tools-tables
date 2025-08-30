<div class="tools-table-wrapper">
    <table class="tools-table">
        <thead>
            <tr>
                @foreach($columns as $column)
                    @unless($column->hidden)
                        <th class="tools-table-th">{{ $column->label }}</th>
                    @endunless
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $index => $row)
                <tr class="tools-table-tr">
                    @foreach($columns as $column)
                        @unless($column->hidden)
                            <td class="tools-table-td">{{ $column->getValue($row, $index) }}</td>
                        @endunless
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
