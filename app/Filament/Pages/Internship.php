<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Models\Internship as ModelsInternship;
use Filament\Forms\Concerns\InteractsWithForms;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Internship extends Page
{
    use InteractsWithForms, HasPageShield;

    public ?array $data = []; 

    protected static ?string $title = 'PKL';

    protected static ?string $navigationGroup = 'Kehumasan';
    protected static ?string $navigationIcon = 'heroicon-s-briefcase';

    protected static string $view = 'filament.pages.internship';

    public function mount(): void
    {
        $this->form->fill(ModelsInternship::find(1)->toArray() ?? []);
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
                Select::make('user_id')
                    ->label('Administrator')
                    ->searchable()
                    ->native(false)
                    ->options(User::all()->pluck('name', 'id'))
                    ->disabled(function () {
                        return !auth()->user()->hasRole(['admin', 'super_admin']);
                    })                       
                    ->required()
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 12,
                    ]),
                FileUpload::make('galleries')
                    ->label('Galeri')
                    ->hint(fn ($component) => 'Minimal ' . $component->getMinFiles() . ' Foto')
                    ->directory('/internships/galleries')
                    ->required()
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('4:3')
                    ->imageResizeTargetWidth('1024')
                    ->imageResizeTargetHeight('768')
                    ->multiple()
                    ->minFiles(2)
                    ->columnSpan([
                        'default' => 2,
                        'lg' => 12,
                    ]),
                RichEditor::make('description')
                    ->label('Deskripsi')
                    ->fileAttachmentsDirectory('/internships/attachments')
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

            ModelsInternship::updateOrCreate(['id' => 1], $data);
        } catch (Halt $exception) {
            return;
        }
    
        Notification::make()
            ->success()
            ->title('Data tersimpan')
            ->send();
    }
}
