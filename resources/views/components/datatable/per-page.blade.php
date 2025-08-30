<div class="tools-table-per-page">
    <select wire:model.live="perPage" class="tools-table-select">
        @foreach($perPageOptions as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>
    <span>Per Page</span>
</div>
