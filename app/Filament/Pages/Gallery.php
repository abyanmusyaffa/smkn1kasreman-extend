<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use App\Models\Gallery as ModelsGallery;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Gallery extends Page
{
    use InteractsWithForms, HasPageShield;

    public ?array $data = []; 

    protected static ?string $title = 'Galeri';

    protected static ?string $navigationGroup = 'Preferensi';
    protected static ?string $navigationIcon = 'fas-image';

    protected static string $view = 'filament.pages.gallery';

    public function mount(): void
    {
        $this->form->fill(ModelsGallery::find(1)->toArray() ?? []);
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
                Repeater::make('galleries')
                    ->label('Galeri')
                    ->minItems(1)
                    ->addActionLabel('Tambahkan Galeri')
                    ->schema([
                        TextInput::make('caption')
                            ->live()
                            ->hint(fn ($state, $component) => 'Sisa ' . $component->getMaxLength() - strlen($state) . ' Karakter') 
                            ->maxLength(42)
                            ->columnSpan([
                                'default' => 2,
                                'lg' => 6,
                            ]),
                        FileUpload::make('photo')
                            ->label('Foto')
                            ->hint('Foto Rasio Aspek 16:9 | Landscape')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('768')
                            ->imageResizeTargetHeight('432')
                            ->directory('galleries')
                            ->required()
                            ->columnSpan([
                                'default' => 2,
                                'lg' => 6,
                            ]),
                    ])
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 12,
                    ]),
                ])
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

            ModelsGallery::updateOrCreate(['id' => 1], $data);
        } catch (Halt $exception) {
            return;
        }
    
        Notification::make()
            ->success()
            ->title('Data tersimpan')
            ->send();
    }
}
