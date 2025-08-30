<?php

namespace Gambito404\ToolsTables\Http\Livewire\DataTable\Traits;

trait WithReordering
{
    public bool $reorderEnabled = false;
    public string $reorderColumn = 'order';

    public function reorder($orderedIds)
    {
        if (!$this->reorderEnabled) {
            return;
        }

        $modelClass = $this->query()->getModel();

        foreach ($orderedIds as $index => $id) {
            $model = $modelClass::find($id);
            if ($model) {
                $model->update([
                    $this->reorderColumn => $index + 1,
                ]);
            }
        }
    }
}
