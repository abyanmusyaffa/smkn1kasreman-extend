<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class Jobfair extends Component
{
    #[Title('Lowongan Pekerjaan')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Lowongan Pekerjaan');
    }
    
    public function render()
    {
        return view('livewire.jobfair');
    }
}
