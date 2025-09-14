<?php

namespace App\Livewire;

use App\Models\Room;
use Livewire\Component;
use Livewire\Attributes\Title;

class LabWorkshop extends Component
{
    #[Title('Lab & Bengkel')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Lab & Bengkel');
    }
    
    public function render()
    {
        return view('livewire.lab-workshop', [
            'labWorkshops' => Room::whereIn('type', ['lab', 'workshop'])->get(),
        ]);
    }
}
