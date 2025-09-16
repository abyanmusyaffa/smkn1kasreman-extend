<?php

namespace App\Filament\Imports;

use App\Models\Student;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class StudentImporter extends Importer
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nis')
                ->label('NIS')
                ->example('0110/233.01')
                ->exampleHeader('NIS')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nisn')
                ->label('NISN')
                ->example('0040113443')
                ->exampleHeader('NISN')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nik')
                ->label('NIK')
                ->example('3521010102020001')
                ->exampleHeader('NIK')
                ->rules(['max:255']),
            ImportColumn::make('nokk')
                ->label('No KK')
                ->example('3521012202020034')
                ->exampleHeader('No KK')
                ->rules(['max:255']),
            ImportColumn::make('name')
                ->label('Nama')
                ->example('Agia Mutiara')
                ->exampleHeader('Nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            // ImportColumn::make('photo')
            //     ->rules(['max:255']),
            ImportColumn::make('phone')
                ->label('No WA')
                ->example('081343567765')
                ->exampleHeader('No WA')
                ->rules(['max:255']),
            ImportColumn::make('email')
                ->label('Email')
                ->example('agia@gmail.com')
                ->exampleHeader('Email')
                ->rules(['email', 'max:255']),
            ImportColumn::make('username')
                ->label('Username')
                ->example('agi0110')
                ->exampleHeader('Username')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('password')
                ->label('Password')
                ->example('skankajaya')
                ->exampleHeader('Password')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            // ImportColumn::make('card_uid')
            //     ->rules(['max:255']),
            ImportColumn::make('previous_school')
                ->label('Sekolah Asal')
                ->example('SMPN 1 Karangjati')
                ->exampleHeader('Sekolah Asal')
                ->rules(['max:255']),
            ImportColumn::make('gender')
                ->label('Jenis Kelamin')
                ->example('female')
                ->exampleHeader('Jenis Kelamin')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('birth_place')
                ->label('Tempat Lahir')
                ->example('Ngawi')
                ->exampleHeader('Tempat Lahir')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('birth_date')
                ->label('Tanggal Lahir')
                ->example('2006-03-17')
                ->exampleHeader('Tanggal Lahir')
                ->requiredMapping()
                ->rules(['required', 'date']),
            ImportColumn::make('religion')
                ->label('Agama')
                ->example('Islam')
                ->exampleHeader('Agama')
                ->rules(['max:255']),
            ImportColumn::make('address')
                ->label('Alamat')
                ->example('Jalan Nakula No.21 Dusun Sukajaya RT002 RW003')
                ->exampleHeader('Alamat')
                ->rules(['max:255']),
            ImportColumn::make('address_village')
                ->label('Desa')
                ->example('Sawo')
                ->exampleHeader('Desa')
                ->rules(['max:255']),
            ImportColumn::make('address_subdistrict')
                ->label('Kecamatan')
                ->example('Karangjati')
                ->exampleHeader('Kecamatan')
                ->rules(['max:255']),
            ImportColumn::make('address_regency')
                ->label('Kabupaten')
                ->example('Ngawi')
                ->exampleHeader('Kabupaten')
                ->rules(['max:255']),
            ImportColumn::make('address_province')
                ->label('Provinsi')
                ->example('Jawa Timur')
                ->exampleHeader('Provinsi')
                ->rules(['max:255']),
            ImportColumn::make('father_name')
                ->label('Nama Ayah')
                ->example('Isman')
                ->exampleHeader('Nama Ayah')
                ->rules(['max:255']),
            ImportColumn::make('father_phone')
                ->label('No WA Ayah')
                ->example('082323456576')
                ->exampleHeader('No WA Ayah')
                ->rules(['max:255']),
            ImportColumn::make('father_job')
                ->label('Pekerjaan Ayah')
                ->example('PNS')
                ->exampleHeader('Pekerjaan Ayah')
                ->rules(['max:255']),
            ImportColumn::make('mother_name')
                ->label('Nama Ibu')
                ->example('Iswati')
                ->exampleHeader('Nama Ibu')
                ->rules(['max:255']),
            ImportColumn::make('mother_phone')
                ->label('No WA Ibu')
                ->example('082323456596')
                ->exampleHeader('No WA Ibu')
                ->rules(['max:255']),
            ImportColumn::make('mother_job')
                ->label('Pekerjaan Ibu')
                ->example('Ibu Rumah Tangga')
                ->exampleHeader('Pekerjaan Ibu')
                ->rules(['max:255']),
            ImportColumn::make('guardian_name')
                ->label('Nama Wali')
                ->example('Rojali')
                ->exampleHeader('Nama Wali')
                ->rules(['max:255']),
            ImportColumn::make('guardian_phone')
                ->label('No WA Wali')
                ->example('082323456098')
                ->exampleHeader('No WA Wali')
                ->rules(['max:255']),
            ImportColumn::make('guardian_job')
                ->label('Pekerjaan Wali')
                ->example('Petani')
                ->exampleHeader('Pekerjaan Wali')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?Student
    {
        // return Student::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Student();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your student import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
