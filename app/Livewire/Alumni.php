<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class Alumni extends Component
{
    #[Title('Cerita Alumni')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Cerita Alumni');
    }
    
    public function render()
    {
        return view('livewire.alumni');
    }
}
