<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class StudentEvents extends Component
{
    #[Title('Agenda Siswa')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Agenda Siswa');
    }

    public function render()
    {
        return view('livewire.student-events');
    }
}
