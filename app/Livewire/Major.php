<?php

namespace App\Livewire;

use App\Models\Major as MajorModel;
use Livewire\Component;
use Livewire\Attributes\Title;

class Major extends Component
{
    #[Title('Program Keahlian')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Program Keahlian');
    }

    public function render()
    {
        return view('livewire.major', [
            'majors' => MajorModel::all(),
        ]);
    }
}
