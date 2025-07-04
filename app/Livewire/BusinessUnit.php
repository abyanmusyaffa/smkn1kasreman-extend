<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class BusinessUnit extends Component
{
    #[Title('UPJ')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'UPJ');
    }
    
    public function render()
    {
        return view('livewire.business-unit');
    }
}
