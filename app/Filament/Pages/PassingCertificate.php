<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use App\Models\PassingCertificate as PassingCertificateModel;
use DateTime;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Date;

class PassingCertificate extends Page implements HasForms
{
    use InteractsWithForms, HasPageShield;

    public ?array $data = []; 
    
    protected static ?string $navigationGroup = 'SKL';
    protected static ?string $navigationIcon = 'fas-print';

    protected static ?string $title = 'Template SKL';

    protected static string $view = 'filament.pages.passing-certificate';

    public function mount(): void
    {
        $this->form->fill(PassingCertificateModel::find(1)->toArray() ?? []); 
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
                    Textarea::make('letterhead')
                        ->required()
                        ->label('Kop Surat')
                        ->maxLength(255)
                        ->rows(5)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    TextInput::make('address')
                        ->label('Alamat')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 12,
                        ]),
                    TextInput::make('school')
                        ->label('Nama Sekolah')
                        ->prefix('SMK Negeri')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 9,
                        ]),
                    TextInput::make('npsn')
                        ->label('NPSN')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    TextInput::make('phone')
                        ->label('Telepon')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    TextInput::make('email')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    TextInput::make('zip_code')
                        ->label('Kode Pos')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    TextInput::make('regency')
                        ->label('Kabupaten')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 3,
                        ]),
                    FileUpload::make('logo')
                        ->image()
                        ->required()
                        ->directory('/passing_certificates')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    FileUpload::make('stamp')
                        ->label('Stempel')
                        ->image()
                        ->required()
                        ->directory('/passing_certificates')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    FileUpload::make('qrcode')
                        ->label('QR Code')
                        ->image()
                        ->required()
                        ->directory('/passing_certificates')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    TextInput::make('number')
                        ->label('Nomor Surat')
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    DatePicker::make('date')
                        ->label('Tanggal Surat')
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    DateTimePicker::make('release_date')
                        ->label('Waktu Rilis')
                        ->required()
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 4,
                        ]),
                    TextInput::make('headmaster')
                        ->label('Nama Kepala Sekolah')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 7,
                        ]),
                    TextInput::make('nip')
                        ->label('NIP Kepala Sekolah')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'default' => 2,
                            'lg' => 5,
                        ]),
                    FileUpload::make('signature')
                        ->label('Tanda Tangan Kepala Sekolah')
                        ->image()
                        ->required()
                        ->directory('/passing_certificates')
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

            PassingCertificateModel::updateOrCreate(['id' => 1], $data);
        } catch (Halt $exception) {
            return;
        }
    
        Notification::make()
            ->success()
            ->title('Data tersimpan')
            ->send();
    }
}
