<?php

namespace App\Livewire;

use App\Models\User;
use Gambito\LivewireTable\Columns\ActionColumn;
use Gambito\LivewireTable\Columns\Column;
use Gambito\LivewireTable\Http\Livewire\BaseTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class UserToolsTable extends BaseTable
{
    public string $style = 'dark';

    protected function columns(): array
    {
        $user = Auth::user();
        return [
            Column::make('id', 'Nro')->sortable(),
            Column::make('name', 'Name')->sortable()->hidden($user->id == 1),
            Column::make('email', 'Email')->sortable(),
            Column::make('created_at', 'Created At')->sortable(),
            Column::make('updated_at', 'Updated At')->sortable(),
            ActionColumn::make('Acciones')
            ->button(
                '<span class="inline-flex items-center bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11.5a1.5 1.5 0 001.5 1.5H17a2 2 0 002-2v-5m-5-5l5 5m0 0L13 19l-5.5-5.5L14 4z" />
                    </svg>
                </span>',
                route: 'settings.profile',
                params: ['id']
            )

            ->button(
                '<span class="inline-flex items-center bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7L5 7M10 11V17M14 11V17M6 7L7 19C7 20.1 7.9 21 9 21H15C16.1 21 17 20.1 17 19L18 7M9 7V4C9 3.4 9.4 3 10 3H14C14.6 3 15 3.4 15 4V7" />
                    </svg>
                 </span>',
                route: 'settings.profile',
                params: ['id']
            )
            
        ];
    }
    
    protected function getRecords(): Builder
    {
        return User::query();
    }
}
