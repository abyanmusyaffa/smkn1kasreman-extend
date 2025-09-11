<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\StudentRegulation as ModelsStudentRegulation;

class StudentRegulation extends Component
{
    #[Title('Tata Tertib')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Tata Tertib');
    }

    public function render()
    {
        return view('livewire.student-regulation', [
            'student_regulation' => ModelsStudentRegulation::first()->value('student_regulation')
        ]);
    }
}
