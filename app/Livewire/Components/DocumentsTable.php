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
        $this->setPaginationDisabled();
        $this->setColumnSelectDisabled();
        
        // Custom styling untuk responsive table
        // $this->setTableWrapperAttributes([
        //     'class' => 'w-full overflow-x-auto'
        // ]);
        
        // $this->setTableAttributes([
        //     'class' => 'w-full !min-w-full table-auto'
        // ]);
        
    }

    public function columns(): array
    {
        return [
            Column::make("Nama Dokumen", "name")
                ->sortable()
                ->searchable(),
            Column::make("Tipe")
                ->sortable()
                ->searchable()
                ->label(function($row) {
                    $type = strtolower($row->type);

                    if (!empty($row->file)) {
                        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                    </svg>
                                    File
                                </span>';
                    } elseif (!empty($row->url)) {
                        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                                    </svg>
                                    URL
                                </span>';
                    }
                    
                    // Default untuk tipe lain
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                ' . ucfirst($row->type) . '
                            </span>';
                })
                ->html(),

            Column::make("URL", "url")->hideIf(true),
            Column::make("File", "file")->hideIf(true),

            Column::make('')
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