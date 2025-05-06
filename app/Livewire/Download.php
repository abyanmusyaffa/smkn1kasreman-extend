<?php

namespace App\Livewire;

use App\Models\Download as DownloadModel;
use Livewire\Component;
use Livewire\Attributes\Title;

class Download extends Component
{
    #[Title('Download Area')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Download Area');
    }

    public function render()
    {
        return view('livewire.download', [
            'download' => DownloadModel::first(),
        ]);
    }
}
