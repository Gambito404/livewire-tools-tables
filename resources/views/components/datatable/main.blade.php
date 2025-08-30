<div>
    <link rel="stylesheet" href="{{ asset('vendor/tools-tables/css/' . $theme . '.css') }}">
    <div class="tools-table-wrapper">
        <div class="tools-table-header">
            <h2 class="text-lg font-bold">{{ $title }}</h2>
        </div>

        @include('tools-tables::components.datatable.table')
    </div>
</div>
