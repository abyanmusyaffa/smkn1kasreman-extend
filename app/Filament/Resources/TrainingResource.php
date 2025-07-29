<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Training;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TrainingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TrainingResource\RelationManagers;

class TrainingResource extends Resource
{
    protected static ?string $model = Training::class;

    protected static ?string $modelLabel = 'Pelatihan';
    protected static ?string $pluralModelLabel = 'Pelatihan';

    protected static ?string $navigationGroup = 'Program Sekolah';
    protected static ?string $navigationIcon = 'fas-certificate';

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
                Forms\Components\TextInput::make('name')
                    ->label('Nama Kegiatan')
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 12,
                    ]),
                Forms\Components\FileUpload::make('photo')
                    ->label('Poster')
                    ->hint('Rasio Aspek 16:9 | Landscape')
                    ->required()
                    ->image()
                    ->maxSize(512)
                    ->directory('/trainings')
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 12,
                    ]),
                Forms\Components\TextInput::make('organizer')
                    ->label('Penyelenggara/Mitra')
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 6,
                    ]),
                Forms\Components\TextInput::make('participants')
                    ->label('Peserta')
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 6,
                    ]),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 6,
                    ]),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 6,
                    ]),
                Forms\Components\TimePicker::make('start_time')
                    ->label('Jam Mulai')
                    ->required()
                    ->seconds(false)
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 3,
                    ]),
                Forms\Components\TimePicker::make('end_time')
                    ->label('Jam Selesai')
                    ->seconds(false)
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 3,
                    ]),
                Forms\Components\TextInput::make('location')
                    ->label('Lokasi')
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 6,
                    ]),
                Forms\Components\RichEditor::make('description')
                    ->label('Deskripsi')
                    ->fileAttachmentsDirectory('/trainings/attachments')
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'h2',
                        'h3',
                        'h4',
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
                Forms\Components\TextInput::make('url')
                    ->label('Tautan Pendaftaran')
                    ->url()
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('organizer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('participants')
                    ->searchable(),
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
            'index' => Pages\ListTrainings::route('/'),
            'create' => Pages\CreateTraining::route('/create'),
            'edit' => Pages\EditTraining::route('/{record}/edit'),
        ];
    }
}
