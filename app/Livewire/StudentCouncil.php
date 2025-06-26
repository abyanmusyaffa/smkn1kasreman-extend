<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class StudentCouncil extends Component
{
    #[Title('OSIS')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'OSIS');
    }
    
    public function render()
    {
        return view('livewire.student-council');
    }
}
