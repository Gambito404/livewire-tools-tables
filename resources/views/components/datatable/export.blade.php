<div class="tools-table-export">
    <select wire:model.live="exportFormat" class="tools-table-select">
        @foreach($exportOptions as $option)
            <option value="{{ $option }}">{{ strtoupper($option) }}</option>
        @endforeach
    </select>
    <button wire:click="export" class="tools-table-button">Export</button>
</div>
