<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardTraining extends Component
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
    public $url;
    public $organizer;
    public $participants;

    public function render()
    {
        return view('livewire.components.card-training');
    }
}
