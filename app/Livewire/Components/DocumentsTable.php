<?php

namespace App\Livewire\Components;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Document;

class DocumentsTable extends DataTableComponent
{
    protected $model = Document::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Nama Dokumen", "name")
                ->sortable()
                ->searchable(),
            Column::make("Tipe", "type")
                ->sortable()
                ->searchable(),

            Column::make("URL", "url")->hideIf(true),
            Column::make("File", "file")->hideIf(true),

            Column::make('Download')
                ->label(function ($row) {
                    if (!empty($row->url)) {
                        if (filter_var($row->url, FILTER_VALIDATE_URL)) {
                            return '<a href="' . e($row->url) . '" target="_blank" class="text-blue-600 hover:underline">
                                        Buka
                                    </a>';
                        }
                    } elseif (!empty($row->file)) {
                        $filename = basename($row->file);
                        $filePath = storage_path('app/public/documents/' . $filename);
                        
                        if (file_exists($filePath)) {
                            $link = asset('storage/documents/' . $filename);
                            return '<a href="' . e($link) . '" target="_blank" download class="text-blue-600 hover:underline">
                                        Unduh
                                    </a>';
                        }
                    }
                    
                    // Jika tidak ada file atau URL yang valid
                    return '<span class="text-gray-400">
                                Tidak tersedia
                            </span>';
                })
                ->html(),
        ];
    }
}
