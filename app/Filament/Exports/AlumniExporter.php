<?php

namespace App\Filament\Exports;

use App\Models\Alumni;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Exports\Enums\ExportFormat;

class AlumniExporter extends Exporter
{
    protected static ?string $model = Alumni::class;

    public static function getColumns(): array
    {
        return [
            // ExportColumn::make('id'),
            ExportColumn::make('nis')
                ->label('NIS'),
            ExportColumn::make('nisn')
                ->label('NISN'),
            ExportColumn::make('name')
                ->label('Nama'),
            ExportColumn::make('groups.name')
                ->label('Kelas'),
            ExportColumn::make('groups.majors.expertise_concentration')
                ->label('Konsentrasi Keahlian'),
            ExportColumn::make('phone')
                ->label('Nomor Telepon'),
            ExportColumn::make('email'),
            // ExportColumn::make('photo'),
            ExportColumn::make('gender')
                ->label('Jenis Kelamin'),
            ExportColumn::make('birth_place')
                ->label('Tempat Lahir'),
            ExportColumn::make('birth_date')
                ->label('Tanggal Lahir'),
            ExportColumn::make('address')
                ->label('Alamat'),
            ExportColumn::make('address_village')
                ->label('Kelurahan/Desa'),
            ExportColumn::make('address_subdistrict')
                ->label('Kecamatan'),
            ExportColumn::make('address_regency')
                ->label('Kabupaten/Kota'),
            ExportColumn::make('address_province')
                ->label('Provinsi'),
            ExportColumn::make('father')
                ->label('Nama Ayah kandung'),
            ExportColumn::make('mother')
                ->label('Nama Ibu Kandung'),
            ExportColumn::make('academic_year')
                ->label('Tahun Ajaran'),
            ExportColumn::make('enrollment_year')
                ->label('Tahun Masuk'),
            ExportColumn::make('passing_year')
                ->label('Tahun Keluar'),
            ExportColumn::make('status'),
            ExportColumn::make('username'),
            // ExportColumn::make('created_at'),
            // ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your alumni export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFormats(): array
    {
        return [
            // ExportFormat::Csv,
            ExportFormat::Xlsx,
        ];
    }

    public function getFileName(Export $export): string
    {
        return "data-siswa-{$export->getKey()}";
    }
}
