<?php

namespace App\Filament\Resources\StaffResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\StaffResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListStaff extends ListRecords
{
    protected static string $resource = StaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            // 'head-master' => Tab::make('Kepala Sekolah')
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'head-master')),
            // 'vice-master' => Tab::make('Wakil Kepala Sekolah')
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'vice-master')),
            // 'head-of-major' => Tab::make('Kakomli')
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'head-of-major')),
            'teacher' => Tab::make('Guru')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'teacher')),
            'staff' => Tab::make('Tenaga Kependidikan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'staff')),
        ];
    }
}
