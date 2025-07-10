<?php

namespace App\Filament\Resources;

use Directory;
use Filament\Forms;
use Filament\Tables;
use App\Models\Article;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Tables\Filters\TabsFilter;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Resources\Components\Tab;
use Filament\Support\Enums\ActionSize;
use Filament\Navigation\NavigationItem;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ArticleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ArticleResource\RelationManagers;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;
    protected static ?string $modelLabel = 'Artikel';
    protected static ?string $pluralModelLabel = 'Artikel';

    protected static ?string $navigationGroup = 'Informasi';
    protected static ?string $navigationIcon = 'fas-newspaper';

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
                        ->live()
                        ->afterStateUpdated(function (bool $state, callable $set, callable $get) {
                            $category = $get('category');
                            $articleId = $get('id'); 
                        
                            if ($category == 'announcement' || $category == 'enrollment') {
                                if ($state) {
                                    $existingPinned = Article::where('category', $category)
                                        ->where('is_pinned', true)
                                        ->where('id', '!=', $articleId)
                                        ->exists();
                        
                                    if ($existingPinned) {
                                        Article::where('category', $category)
                                            ->where('is_pinned', true)
                                            ->where('id', '!=', $articleId)
                                            ->update(['is_pinned' => false]); 
                        
                                        Notification::make()
                                            ->success()
                                            ->title('Berhasil Disematkan')
                                            ->body('Hanya Satu Artikel yang Bisa Disematkan di Kategori ' . ($category == 'announcement' ? 'Pengumuman' : 'Informasi PPDB'))
                                            ->send();
                                    }
                        
                                    $set('is_pinned', true);
                                } else {
                                    $set('is_pinned', false);
                                }
                            }
                        })               
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\Toggle::make('is_published')
                        ->label('Publish')
                        ->required()
                        ->default(true)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\Toggle::make('is_headline')
                        ->label('Headline')
                        ->live()
                        ->afterStateUpdated(function (bool $state, callable $set, callable $get) {
                            $category = $get('category');
                            $articleId = $get('id'); 
                        
                            if ($state) {
                                Article::whereIn('category', ['announcement', 'enrollment'])
                                    ->where('is_headline', true)
                                    ->where('id', '!=', $articleId)
                                    ->update(['is_headline' => false]);
                        
                                $set('is_headline', true);
                        
                                Notification::make()
                                    ->success()
                                    ->title('Artikel ditampilkan di Headline Text')
                                    ->send();
                            } else {
                                $set('is_headline', false);
                            }
                        })                                                        
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    Forms\Components\TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\Hidden::make('slug'),
                    Forms\Components\FileUpload::make('photo')
                        ->label('Foto')
                        ->image()
                        ->directory('/articles')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    Forms\Components\RichEditor::make('content')
                        ->label('isi')
                        ->fileAttachmentsDirectory('/attachments-article')
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
                            'lg' => 8,
                        ]),
                    Forms\Components\Select::make('category')
                        ->label('Kategori')
                        ->options([
                            'news' => 'Berita',
                            'announcement' => 'Pengumuman',
                            'enrollment' => 'Informasi SPMB',
                        ])
                        ->native(false)
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
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
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_pinned')
                    ->afterStateUpdated(function ($state, $record) {
                        if ($record->category == 'announcement' || $record->category == 'enrollment') {
                            if ($state) {
                                $existingPinned = Article::where('category', $record->category)
                                    ->where('is_pinned', true)
                                    ->where('id', '!=', $record->id) 
                                    ->exists();
                    
                                if ($existingPinned) {
                                    Article::where('category', $record->category)
                                        ->where('is_pinned', true)
                                        ->where('id', '!=', $record->id)
                                        ->update(['is_pinned' => false]);
                    
                                    Notification::make()
                                        ->success()
                                        ->title('Berhasil Disematkan')
                                        ->body('Hanya Satu Artikel yang Bisa Disematkan di Kategori ' . ($record->category  == 'announcement' ? 'Pengumuman' : 'Informasi PPDB'))
                                        ->send();
                                }
                    
                                $record->is_pinned = true;
                                $record->save();
                            } else {
                                $record->is_pinned = false;
                                $record->save();
                            }
                        }
                    })
                    ->sortable()
                    ->label('Sematkan'),
                Tables\Columns\ToggleColumn::make('is_headline')
                    ->label('Headline')
                    ->sortable()
                    ->afterStateUpdated(function (bool $state, Article $record) {
                        if ($state) {
                            Article::whereIn('category', ['announcement', 'enrollment'])
                                ->where('is_headline', true)
                                ->where('id', '!=', $record->id)
                                ->update(['is_headline' => false]);
                
                            Notification::make()
                                ->success()
                                ->title('Artikel ditampilkan di Headline Text')
                                ->send();
                        }
                
                        $record->is_headline = $state;
                        $record->save();
                    }),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Publish')
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
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([

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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
