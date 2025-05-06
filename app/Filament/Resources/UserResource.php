<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Section;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Admin';
    protected static ?string $pluralModelLabel = 'Admin';
    protected static ?string $navigationGroup = 'Manajemen Admin';

    protected static ?string $navigationIcon = 'fas-users';

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
                        ->label('Nama')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 8,
                        ]),
                    Forms\Components\Select::make('roles')
                        ->label('Peran')
                        ->native(false)
                        ->relationship(name: 'roles', titleAttribute: 'name')
                        ->options(function () {
                            $user = auth()->user();
                            if ($user->hasRole('admin')) {
                                return \Spatie\Permission\Models\Role::where('name', 'author')->pluck('name', 'id');
                            }
    
                            return \Spatie\Permission\Models\Role::pluck('name', 'id');
                        })
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\TextInput::make('username')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->required(fn (string $operation): bool => $operation == 'create')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (auth()->user()->hasRole('admin')) {
                    $query->whereDoesntHave('roles', function ($query) {
                        $query->where('name', 'super_admin');
                    });
                }
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Peran')
                    ->formatStateUsing(fn ($state): string => Str::headline($state))
                    ->badge()
                    ->color(function (string $state): string {
                        $colors = ['success', 'info', 'danger'];

                        $index = crc32($state) % count($colors);
                        return $colors[$index];
                    }),
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
            ])
            ->defaultSort('name')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
