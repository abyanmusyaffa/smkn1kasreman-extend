<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ArticleResource;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'news' => Tab::make('Berita')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'news')),
            'announcement' => Tab::make('Pengumuman')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'announcement')),
            'enrollment' => Tab::make('Informasi PPDB')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'enrollment')),
        ];
    }
}
