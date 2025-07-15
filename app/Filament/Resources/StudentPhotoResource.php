<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\StudentPhoto;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentPhotoResource\Pages;
use App\Filament\Resources\StudentPhotoResource\RelationManagers;

class StudentPhotoResource extends Resource
{
    protected static ?string $model = StudentPhoto::class;

    protected static ?string $modelLabel = 'Foto Siswa';
    protected static ?string $pluralModelLabel = 'Foto Siswa';

    protected static ?string $navigationGroup = 'Siswa';
    protected static ?string $navigationIcon = 'fas-chalkboard-teacher';

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
                    Forms\Components\Select::make('group_id')
                        ->label('Kelas')
                        ->native(false)
                        ->searchable()
                        ->relationship(name: 'groups', titleAttribute: 'name')
                        ->live()
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\FileUpload::make('photos')
                        ->label('Foto Siswa')
                        ->multiple()
                        ->preserveFilenames()
                        ->image()
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('3:4')
                        ->imageResizeTargetWidth('300')
                        ->imageResizeTargetHeight('400')
                        ->panelLayout('grid')
                        ->reorderable()
                        // ->directory(fn ($record) => 'alumnis/' . Str::slug($record?->groups?->name ?? 'unknown'))
                        ->directory(function (callable $get) {
                            // Get the current group_id from the form state
                            $groupId = $get('group_id');
                            
                            // If using Livewire 3 and have group relationship directly in the form
                            if ($groupName = $get('groups.name')) {
                                return 'alumnis/' . Str::slug($groupName);
                            }
                            
                            // If using a Select with group_id, you might need to manually fetch the group name
                            // This is a fallback for when the group name isn't directly available in the form
                            if ($groupId) {
                                // Assuming you have a Group model
                                $group = \App\Models\Group::find($groupId);
                                return 'alumnis/' . Str::slug($group?->name ?? 'unknown');
                            }
                            
                            return 'alumnis/unknown';
                        })
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
            ->groups([
                Group::make('groups.majors.alias')
                    ->label('Jurusan'),
            ])
            ->defaultGroup('groups.majors.alias')
            ->groupingSettingsHidden()
            ->columns([
                Tables\Columns\TextColumn::make('groups.name')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStudentPhotos::route('/'),
            'create' => Pages\CreateStudentPhoto::route('/create'),
            'edit' => Pages\EditStudentPhoto::route('/{record}/edit'),
        ];
    }
}
