<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardStudentEvent extends Component
{
    public $id;
    public $name;
    public $photo;
    public $description;
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $location;

    public function render()
    {
        return view('livewire.components.card-student-event');
    }
}
