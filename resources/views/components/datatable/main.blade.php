<div>
    <link rel="stylesheet" href="{{ $themeCss }}">

    <div class="tools-table-container">
        <div class="tools-table-header">
            @include('tools-tables::components.datatable.search')
            @include('tools-tables::components.datatable.per-page')
            @include('tools-tables::components.datatable.export')
        </div>

        @include('tools-tables::components.datatable.table')

        @include('tools-tables::components.datatable.pagination')
    </div>
</div>
