<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Pages\ViewAchievement;
use App\Models\Achievement;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AchievementResource\Pages;
use App\Filament\Resources\AchievementResource\RelationManagers;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;
    protected static ?string $modelLabel = 'Prestasi';
    protected static ?string $pluralModelLabel = 'Prestasi';

    protected static ?string $navigationGroup = 'Sekolah';
    protected static ?string $navigationIcon = 'fas-medal';

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
                    Forms\Components\Toggle::make('is_pinned')
                    ->label('Sematkan')
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 12,
                    ]),
                    Forms\Components\TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 9,
                        ]),
                    Forms\Components\Hidden::make('slug'),
                    Forms\Components\TextInput::make('rankings')
                        ->label('Peringkat')
                        ->placeholder('Juara 1')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Forms\Components\FileUpload::make('photo')
                        ->image()
                        ->label('Foto')
                        ->required()
                        ->directory('/achievements')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\RichEditor::make('content')
                        ->label('Isi')
                        ->fileAttachmentsDirectory('/attachments-achievement')
                        ->toolbarButtons([
                            'attachFiles',
                            'blockquote',
                            'bold',
                            'bulletList',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TagsInput::make('tags')
                        ->label('Tagar')
                        ->splitKeys(['Tab'])
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\Hidden::make('user_id')
                        ->default(fn () => Auth::id()),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rankings')
                    ->label('Peringkat')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_pinned')
                    ->label('Sematkan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievement::route('/create'),
            // 'view' => Pages\ViewAchievement::route('/{record}'),
            'edit' => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
