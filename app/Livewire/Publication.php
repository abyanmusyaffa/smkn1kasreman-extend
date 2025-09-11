<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class Publication extends Component
{
    #[Title('Publikasi')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Publikasi');
    }

    public function render()
    {
        return view('livewire.publication');
    }
}
