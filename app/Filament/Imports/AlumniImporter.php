<?php

namespace App\Filament\Imports;

use App\Models\Alumni;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class AlumniImporter extends Importer
{
    protected static ?string $model = Alumni::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nis')
                ->label('NIS')
                ->requiredMapping()
                ->example('1234/567.890')
                ->rules(['required', 'max:255']),
            ImportColumn::make('nisn')
                ->label('NISN')
                ->requiredMapping()
                ->example('0040050006')
                ->rules(['required', 'max:255']),
            ImportColumn::make('name')
                ->label('Nama')
                ->requiredMapping()
                ->example('John Doe')
                ->rules(['required', 'max:255']),
            ImportColumn::make('phone')
                ->label('Nomor Telepon')
                // ->requiredMapping()
                ->example('082345654765'),
            ImportColumn::make('email')
                // ->requiredMapping()
                ->example('johndoe@mail.com'),
            ImportColumn::make('photo')
                ->label('Foto')
                ->rules(['max:255']),
            ImportColumn::make('gender')
                ->label('Jenis Kelamin')
                ->requiredMapping()
                ->example('male')
                // ->in(['male', 'demale'])
                // ->validationRules(['in:male,female'])
                ->rules(['required', 'in:male,female']),
            ImportColumn::make('birth_place')
                ->label('Tempat Lahir')
                ->requiredMapping()
                ->example('Jakarta')
                ->rules(['required', 'max:255']),
            ImportColumn::make('birth_date')
                ->label('Tanggal Lahir')
                ->requiredMapping()
                ->example('2000-01-01')
                ->rules(['required', 'date'])
                ->castStateUsing(fn (string $state): string => date('Y-m-d', strtotime($state))),
            ImportColumn::make('address')
                ->label('Alamat')
                // ->requiredMapping()
                ->example('Jalan Nakula No.21 Dusun Sukajaya RT002 RW003'),
            ImportColumn::make('address_village')
                ->label('kelurahan/Desa')
                // ->requiredMapping()
                ->example('Cangakan'),
            ImportColumn::make('address_subdistrict')
                ->label('Kecamatan')
                // ->requiredMapping()
                ->example('Kasreman'),
            ImportColumn::make('address_regency')
                ->label('Kabupaten/Kota')
                // ->requiredMapping()
                ->example('Ngawi'),
            ImportColumn::make('address_province')
                ->label('Provinsi')
                // ->requiredMapping()
                ->example('Jawa Timur'),
            ImportColumn::make('father')
                ->label('Nama Bapak')
                ->requiredMapping()
                ->example('Suparno'),
            ImportColumn::make('mother')
                ->label('Nama Ibu')
                // ->requiredMapping()
                ->example('Sulastri'),
            ImportColumn::make('academic_year')
                ->label('Tahun Ajaran')
                ->requiredMapping()
                ->example('2024/2025')
                ->rules(['required', 'max:255']),
            ImportColumn::make('enrollment_year')
                ->label('Tahun Masuk')
                ->requiredMapping()
                ->example('2020')
                ->rules(['required', 'max:255']),
            ImportColumn::make('passing_year')
                ->label('Tahun Keluar')
                ->example('2023')
                ->rules(['max:255']),
            ImportColumn::make('status')
                ->requiredMapping()
                ->example('active')
                // ->in(['active', 'passing', 'transferred', 'dropped'])
                // ->validationRules(['in:active,passing,transferred,dropped'])
                ->rules(['required', 'in:active,passing,transferred,dropped']),
            ImportColumn::make('username')
                ->requiredMapping()
                ->example('joh101')
                ->rules(['required', 'max:255']),
            ImportColumn::make('password')
                ->requiredMapping()
                ->example('alumni')
                ->rules(['required', 'max:255'])
                ->castStateUsing(fn (string $state): string => Hash::make($state)),
            ImportColumn::make('group_id')
                ->label('Kelas')
                ->requiredMapping()
                ->numeric()
                ->example('1')
                ->rules(['required', 'integer']),
        ];
    }

    // Tambahkan kolom dinamis untuk nilai mata pelajaran
    public function getImportColumns(): array
    {
        $columns = parent::getImportColumns();
        
        // Dapatkan semua mata pelajaran
        $subjects = Subject::all();
        
        // Tambahkan kolom untuk setiap mata pelajaran
        foreach ($subjects as $subject) {
            $columns[] = ImportColumn::make("subject_{$subject->id}")
                ->label("Nilai {$subject->name}")
                ->example('85')
                ->validate(['nullable', 'numeric', 'min:0', 'max:100']);
        }
        
        return $columns;
    }

    public function resolveRecord(): ?Alumni
    {
        // Cek jika record sudah ada berdasarkan username atau nisn
        return Alumni::firstOrNew([
            'username' => $this->data['username'],
            'nisn' => $this->data['nisn'],
            'nis' => $this->data['nis'],
            // Anda bisa gunakan NISN atau kombinasi lain sebagai identifikasi unik
        ]);
    }

    protected function afterSave(): void
    {
        // Dapatkan record dan data dari properti class
        $record = $this->record;
        $data = $this->data;
        
        // Proses nilai-nilai untuk setiap mata pelajaran
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'subject_') && !is_null($value) && $value !== '') {
                $subjectId = (int) str_replace('subject_', '', $key);
                
                // Buat atau update nilai
                $record->scores()->updateOrCreate(
                    ['subject_id' => $subjectId],
                    ['score' => (float) $value]
                );
            }
        }
    }

    // public function resolveRecord(): ?Alumni
    // {
    //     // return Alumni::firstOrNew([
    //     //     // Update existing records, matching them by `$this->data['column_name']`
    //     //     'email' => $this->data['email'],
    //     // ]);

    //     return new Alumni();
    // }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your alumni import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    // Method untuk menampilkan contoh header dan baris data
    // public static function getExampleCsvRow(): array
    // {
    //     $row = [
    //         'username' => 'john100',
    //         'password' => 'alumni',
    //         'name' => 'John Doe',
    //         'gender' => 'male',
    //         'birth_place' => 'Jakarta',
    //         'birth_date' => '2000-01-01',
    //         'nis' => '1234/567.890',
    //         'nisn' => '0040050006',
    //         'group_id' => '1',
    //         'enrollment_year' => '2020',
    //         'passing_year' => '2023',
    //         'status' => 'active',
    //     ];
        
    //     // Tambahkan contoh nilai untuk setiap mata pelajaran
    //     $subjects = Subject::all();
    //     foreach ($subjects as $subject) {
    //         $row["subject_{$subject->id}"] = '85';
    //     }
        
    //     return $row;
    // }
}
