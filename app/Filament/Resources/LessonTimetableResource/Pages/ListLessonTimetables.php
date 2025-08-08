<?php

namespace App\Filament\Resources\LessonTimetableResource\Pages;

use App\Models\Group;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LessonTimetableResource;

class ListLessonTimetables extends ListRecords
{
    protected static string $resource = LessonTimetableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
        ];
    }

    // public function getTabs(): array
    // {
    //     return \App\Models\Group::all()->mapWithKeys(function ($group) {
    //         return [
    //             (string) $group->id => Tab::make($group->name)
    //                 ->modifyQueryUsing(function (Builder $query) use ($group) {
    //                     return $query->where('group_id', $group->id);
    //                 })
    //                 ->extraAttributes(['class' => 'whitespace-nowrap']),
    //         ];
    //     })->toArray();
    // }
}
