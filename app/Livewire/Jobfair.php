<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class Jobfair extends Component
{
    #[Title('Bursa Kerja Khusus')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Bursa Kerja Khusus');
    }
    
    public function render()
    {
        return view('livewire.jobfair');
    }
}
