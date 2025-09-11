<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class AcademicCalendar extends Component
{
    #[Title('Kalender Akademik')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Kalender Akademik');
    }

    public function render()
    {
        return view('livewire.academic-calendar');
    }
}
