<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class Training extends Component
{
    #[Title('Pelatihan')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Pelatihan');
    }
    
    public function render()
    {
        return view('livewire.training');
    }
}
