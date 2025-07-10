<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Extracurricular;

class StudentCouncil extends Component
{
    #[Title('OSIS')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'OSIS');
    }
    
    public function render()
    {
        return view('livewire.student-council', [
            'osis' => Extracurricular::where('name', 'like', '%osis%')->first()
        ]);
    }
}
