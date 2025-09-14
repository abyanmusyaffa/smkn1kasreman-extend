<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\AcademicCalendar as ModelsAcademicCalendar;

class AcademicCalendar extends Component
{
    #[Title('Kalender Akademik')]
    public $events = [];
    
    public function mount()
    {
        $this->dispatch('title', title: 'Kalender Akademik');

        $this->events = ModelsAcademicCalendar::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->start_date->toDateString(),
                'end' => $event->end_date ? Carbon::parse($event->end_date)->addDay()->toDateString() : null,
                'description' => $event->description,
                'color' => $event->color,
                // 'allDay' => true,
            ];
        });
    }

    public function render()
    {
        return view('livewire.academic-calendar');
    }
}
