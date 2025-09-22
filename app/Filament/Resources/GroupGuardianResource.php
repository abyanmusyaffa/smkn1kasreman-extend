<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Group;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcademicYear;
use App\Models\GroupGuardian;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GroupGuardianResource\Pages;
use App\Filament\Resources\GroupGuardianResource\RelationManagers;

class GroupGuardianResource extends Resource
{
    protected static ?string $model = GroupGuardian::class;

    protected static ?string $modelLabel = 'Wali Kelas';
    protected static ?string $pluralModelLabel = 'Wali Kelas';

    protected static ?string $navigationGroup = 'Kurikulum';
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
                    Forms\Components\Select::make('staff_id')
                        ->label('Wali Kelas')
                        ->required()
                        ->native(false)
                        ->searchable()
                        ->relationship('staff', 'name')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Select::make('group_id')
                        ->label('Kelas')
                        ->required()
                        ->native(false)
                        ->searchable()
                        ->relationship(name: 'groups', titleAttribute: 'name')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\Select::make('academic_year_id')
                        ->label('Tahun Ajar')
                        ->required()
                        ->native(false)
                        // ->searchable()
                        ->relationship(
                            name: 'academic_years',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn ($query) => $query->select('id', 'name', 'semester')
                        )
                        ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - Semester {$record->semester}")
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    // Forms\Components\Toggle::make('is_active')
                    //     ->label('')
                    //     ->required()
                    //     ->columnSpan([
                    //         'default' => 2,
                    //         'lg' => 4,
                    //     ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('staff.name')
                    ->label('Wali Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('groups.name')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('academic_years_display')
                    ->label('Tahun Ajar')
                    ->alignCenter()
                    ->getStateUsing(fn ($record) => $record->academic_years
                        ? $record->academic_years->name . ' - ' . ($record->academic_years->semester == '1' ? 'Ganjil' : 'Genap')
                        : '-'
                    )
                    ->badge()
                    ->color(fn ($record) => $record->academic_years?->semester == '1' ? 'info' : 'success')
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
                SelectFilter::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship(
                        name: 'academic_years',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->select('id', 'name', 'semester')->orderBy('name', 'desc')
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} - " . ($record->semester == 1 ? 'Ganjil' : 'Genap'))
                    ->default(AcademicYear::where('is_active', true)->first()?->id),
                
                SelectFilter::make('group_id')
                    ->label('Kelas')
                    ->options(Group::pluck('name', 'id'))
                    ->searchable(),
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
            'index' => Pages\ListGroupGuardians::route('/'),
            'create' => Pages\CreateGroupGuardian::route('/create'),
            'edit' => Pages\EditGroupGuardian::route('/{record}/edit'),
        ];
    }
}
