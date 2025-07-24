<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use App\Models\Document;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DocumentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DocumentResource\RelationManagers;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $modelLabel = 'Dokumen';
    protected static ?string $pluralModelLabel = 'Dokumen';

    protected static ?string $navigationGroup = 'Preferensi';

    protected static ?string $navigationIcon = 'heroicon-s-document';

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
                        ->label('Nama Dokumen')
                        ->required()
                        ->live()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Radio::make('type')
                        ->label('Tipe Dokumen')
                        ->options([
                            'file' => 'File',
                            'url' => 'Tautan (Link)',
                        ])
                        ->descriptions([
                            'file' => 'Pilih tipe File jika dokumen tidak lebih dari 5MB',
                            'url' => 'Pilih tipe Tautan jika dokumen lebih dari 5MB (Upload terlebih dahulu pada Google Drive / Lainnya)',
                        ])
                        ->required()
                        ->inline()
                        ->inlineLabel(false)
                        ->live()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]), 
                    Forms\Components\FileUpload::make('file')
                        ->label('File Dokumen')
                        ->directory('documents')
                        ->maxSize(5120)
                        ->acceptedFileTypes([
                            'application/pdf',
                            'application/msword',                         // .doc
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
                            'application/vnd.ms-excel',                   // .xls
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',       // .xlsx
                            'application/vnd.ms-powerpoint',              // .ppt
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation', // .pptx
                            'image/*',                                     // semua jenis gambar
                        ])
                        ->downloadable()
                        ->visible(fn (Get $get) => $get('type') === 'file')
                        ->required(fn (Get $get) => $get('type') === 'file')
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $get): string {
                            $slug = Str::slug($get('name') ?? 'file');
                            return "{$slug}-" . now()->timestamp . "." . $file->getClientOriginalExtension();
                        })
                        // ->rule(function (Get $get) {
                        //     return function (string $attribute, $value, Closure $fail) use ($get) {
                        //         if ($get('type') === 'file' && $get('url')) {
                        //             $fail('Tidak boleh mengisi file dan tautan sekaligus.');
                        //         }
                        //     };
                        // })
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\TextInput::make('url')
                        ->label('Tautan Dokumen')
                        ->visible(fn (Get $get) => $get('type') === 'url')
                        ->required(fn (Get $get) => $get('type') === 'url')
                        ->url()
                        // ->rule(function (Get $get) {
                        //     return function (string $attribute, $value, Closure $fail) use ($get) {
                        //         if ($get('type') === 'url' && $get('file')) {
                        //             $fail('Tidak boleh mengisi file dan tautan sekaligus.');
                        //         }
                        //     };
                        // })
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
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            'file' => 'File',
                            'url' => 'Tautan',
                        };
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'file' => 'info',
                        'url' => 'warning',
                    }),
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
