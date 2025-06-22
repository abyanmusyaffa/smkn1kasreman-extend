<?php

namespace App\Filament\Pages;

use App\Models\School;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class About extends Page implements HasForms
{
    use InteractsWithForms, HasPageShield;

    public ?array $data = []; 

    protected static ?string $navigationGroup = 'Sekolah';
    protected static ?string $navigationIcon = 'heroicon-s-document-text';

    protected static ?string $title = 'Data Sekolah';

    protected static string $view = 'filament.pages.about';

    public function mount(): void
    {
        $this->form->fill(School::find(1)->toArray() ?? []);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    FileUpload::make('logo')
                        ->image()
                        ->directory('/logo')
                        ->label('Logo')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 5,
                        ]),
                    TextInput::make('name')
                        ->prefix('SMK Negeri')
                        ->label('Nama Sekolah')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    TextInput::make('alias')
                        ->label('Alias')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    Textarea::make('address')
                        ->label('Alamat')
                        ->rows(3)
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 5
                        ]),
                    TextInput::make('phone')
                        ->label('Telepon')
                        ->tel()
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
            ]),
            Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    TextInput::make('url_instagram')
                        ->url()
                        ->label('Link Instagram')
                        ->columnSpan([
                            'default' => 1,
                            'lg' => 3,
                        ]),
                    TextInput::make('url_facebook')
                        ->url()
                        ->label('Link Facebook')
                        ->columnSpan([
                            'default' => 1,
                            'lg' => 3
                        ]),
                    TextInput::make('url_youtube')
                        ->url()
                        ->label('Link Youtube')
                        ->columnSpan([
                            'default' => 1,
                            'lg' => 3,
                        ]),
                    TextInput::make('url_tiktok')
                        ->url()
                        ->label('Link Tiktok')
                        ->columnSpan([
                            'default' => 1,
                            'lg' => 3,
                        ]),
            ]),
            Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    TextInput::make('motto')
                        ->label('Moto Sekolah')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    RichEditor::make('vision')
                        ->label('Visi Sekolah')
                        ->toolbarButtons([
                            'bold',
                            'bulletList',
                            'italic',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6,
                        ]),
                    RichEditor::make('mission')
                        ->label('Misi Sekolah')
                        ->toolbarButtons([
                            'bold',
                            'bulletList',
                            'italic',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 6
                        ]),
            ]),
            Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    TextInput::make('url_video_profile')
                        ->label('Link Video Profil')
                        ->url()
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    RichEditor::make('description')
                        ->label('Profil Sekolah')
                        ->toolbarButtons([
                            'bold',
                            'bulletList',
                            'italic',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12
                        ]),
            ]),
            Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    TextArea::make('welcome_text')
                        ->rows(16)
                        ->label('Sambutan Kepala Sekolah')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12
                        ]),
            ]),
            Section::make()
                ->columns([
                    'default' => 2,
                    'lg' => 12,
                ])
                ->schema([
                    FileUpload::make('school_map')
                        ->image()
                        ->directory('/logo')
                        ->label('Denah Sekolah')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12
                        ]),
            ]),
        ])
        ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            School::updateOrCreate(['id' => 1], $data);
        } catch (Halt $exception) {
            return;
        }
    
        Notification::make()
            ->success()
            ->title('Data tersimpan')
            ->send();
    }

    private function getYoutubeVideoId(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        preg_match(
            '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $url,
            $matches
        );

        return $matches[1] ?? null;
    }
    
}
