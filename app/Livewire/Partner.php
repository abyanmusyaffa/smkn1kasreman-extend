<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class Partner extends Component
{
    #[Title('Mitra DU/DI')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Mitra DU/DI');
    }
    
    public function render()
    {
        return view('livewire.partner');
    }
}
