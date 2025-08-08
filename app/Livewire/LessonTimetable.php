<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class LessonTimetable extends Component
{
    #[Title('Jadwal Pelajaran')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Jadwal Pelajaran');
    }
    
    public function render()
    {
        return view('livewire.lesson-timetable');
    }
}
