<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Testimonial;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Resources\TestimonialResource\RelationManagers;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;
    protected static ?string $modelLabel = 'Testimoni Alumni';
    protected static ?string $pluralModelLabel = 'Testimoni Alumni';

    protected static ?string $navigationGroup = 'Kehumasan';
    protected static ?string $navigationIcon = 'heroicon-s-chat-bubble-bottom-center-text';

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
                    Forms\Components\Toggle::make('show')
                        ->default(true)
                        ->label('Tampilkan')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Select::make('alumni_id')
                        ->native(false)
                        ->relationship(name: 'alumnis', titleAttribute: 'name')
                        ->label('Alumni')
                        ->required()
                        ->searchable()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 9,
                        ]),
                    Forms\Components\TextInput::make('rating')
                        ->maxValue(5)
                        ->required()
                        ->numeric()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Forms\Components\TextInput::make('position')
                        ->label('Pekerjaan')
                        ->live()
                        ->hint(fn ($state, $component) => 'Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter')
                        ->maxLength(24)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('company')
                        ->live()
                        ->hint(fn ($state, $component) => 'Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter')
                        ->maxLength(24)
                        ->label('Instansi')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\Textarea::make('content')
                        ->label('Isi')
                        ->rows(6)
                        ->live()
                        ->hint(fn ($state, $component) => strlen($state) . ' Karakter | Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter') 
                        ->maxlength(400) 
                        ->helperText('Minimal 100 Karakter')
                        ->minLength(100)
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('alumnis.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()                    
                    ->url(fn ($record) => route('filament.admin.resources.alumnis.edit', ['record' => $record->alumnis->id]))
                    ->openUrlInNewTab(false),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        5 => 'info',
                        4 => 'gray',
                        3 => 'success',
                        2 => 'warning',
                        1 => 'danger',
                    })
                    ->icon('fas-star')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Pekerjaan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company')
                    ->label('Instansi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('show')
                    ->label('Tampilkan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->size(ActionSize::Large)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('updateShow')
                    ->label('Tampilkan')
                    ->icon('fas-eye')
                    ->color('success')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $record->update([
                                'show' => true,
                            ]);
                        }
                    })
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion(),
                    BulkAction::make('updateHide')
                    ->label('Jangan Tampilkan')
                    ->icon('fas-eye-slash')
                    ->color('warning')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $record->update([
                                'show' => false,
                            ]);
                        }
                    })
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion(),
                ]),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
