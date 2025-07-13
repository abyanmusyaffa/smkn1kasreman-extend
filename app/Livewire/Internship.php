<?php

namespace App\Livewire;

use App\Models\Internship as ModelsInternship;
use Livewire\Component;
use Livewire\Attributes\Title;

class Internship extends Component
{
    #[Title('Praktek Kerja Lapangan')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Praktek Kerja Lapangan');
    }
    
    public function render()
    {
        return view('livewire.internship', [
            'internship' => ModelsInternship::first(),
        ]);
    }
}
