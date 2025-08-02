<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Gallery as ModelsGallery;

class Gallery extends Component
{
    #[Title('Galeri')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Galeri');
    }
    
    public function render()
    {
        return view('livewire.gallery', [
            'galleries' => ModelsGallery::value('galleries'),
        ]);
    }
}
