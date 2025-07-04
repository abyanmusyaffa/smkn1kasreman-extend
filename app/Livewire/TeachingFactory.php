<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class TeachingFactory extends Component
{
    #[Title('Teaching Factory')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Teaching Factory');
    }
    
    public function render()
    {
        return view('livewire.teaching-factory');
    }
}
