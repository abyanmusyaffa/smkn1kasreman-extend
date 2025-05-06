<?php

namespace App\Filament\Pages;

use App\Models\Download as DownloadModel;
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

class Download extends Page implements HasForms
{
    use InteractsWithForms, HasPageShield;

    public ?array $data = []; 

    protected static ?string $navigationGroup = 'Preferensi';
    protected static ?string $navigationIcon = 'fas-cloud-download-alt';

    protected static ?string $title = 'Download Area';

    protected static string $view = 'filament.pages.about';

    public function mount(): void
    {
        $this->form->fill(DownloadModel::find(1)->toArray() ?? []); 
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
                    RichEditor::make('content')
                        ->label('')
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
                        ->fileAttachmentsDirectory('/attachments-download')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
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

            DownloadModel::updateOrCreate(['id' => 1], $data);
        } catch (Halt $exception) {
            return;
        }
    
        Notification::make()
            ->success()
            ->title('Data tersimpan')
            ->send();
    }

}
