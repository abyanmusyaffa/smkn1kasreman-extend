<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Photo;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PhotoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PhotoResource\RelationManagers;

class PhotoResource extends Resource
{
    protected static ?string $model = Photo::class;
    protected static ?string $modelLabel = 'Galeri';
    protected static ?string $pluralModelLabel = 'Galeri';

    protected static ?string $navigationGroup = 'Preferensi';
    protected static ?string $navigationIcon = 'fas-image';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    Forms\Components\FileUpload::make('photo')
                        ->image()
                        ->label(function (callable $get) {
                            return $get('type') === 'hero' ? 'Hero' : 'Galeri Skanka';
                        })
                        ->multiple()
                        ->directory('/photos')
                        ->required()
                        ->minFiles(function (callable $get) {
                            return $get('type') === 'hero' ? 3 : 5; 
                        })
                        ->maxFiles(function (callable $get) {
                            return $get('type') === 'hero' ? 5 : 5;
                        })
                        ->panelLayout('grid')
                        ->reorderable()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Hidden::make('type'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'hero' => 'Hero',
                        'gallery' => 'Galeri Skanka',
                    })
                    ->description(fn (string $state): string => match ($state) {
                        'hero' => 'Ditampilkan dibagian awal halaman beranda',
                        'gallery' => 'Ditampilkan dibagian Galeri',
                    })
                    ->label('')
                    ->weight(FontWeight::Bold),
                Tables\Columns\ImageColumn::make('photo')
                    ->label('')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->size(100),
            ])
            ->paginated(false)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhotos::route('/'),
            'create' => Pages\CreatePhoto::route('/create'),
            'edit' => Pages\EditPhoto::route('/{record}/edit'),
        ];
    }
}
