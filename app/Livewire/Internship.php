<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class Internship extends Component
{
    #[Title('Praktek kerja Lapangan')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Praktek kerja Lapangan');
    }
    
    public function render()
    {
        return view('livewire.internship');
    }
}
