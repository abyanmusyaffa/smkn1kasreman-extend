<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use App\Models\StudentRegulation as ModelsStudentRegulation;

class StudentRegulation extends Page
{
    use InteractsWithForms, HasPageShield;

    public ?array $data = []; 

    protected static ?string $title = 'Tata Tertib';

    protected static ?string $navigationGroup = 'Kesiswaan';
    protected static ?string $navigationIcon = 'heroicon-s-queue-list';

    protected static string $view = 'filament.pages.student-regulation';

    public function mount(): void
    {
        $this->form->fill(ModelsStudentRegulation::find(1)->toArray() ?? []);
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
                RichEditor::make('student_regulation')
                    ->label('Tata Tertib')
                    ->fileAttachmentsDirectory('/student-regulations/attachments')
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

            ModelsStudentRegulation::updateOrCreate(['id' => 1], $data);
        } catch (Halt $exception) {
            return;
        }
    
        Notification::make()
            ->success()
            ->title('Data tersimpan')
            ->send();
    }
}
