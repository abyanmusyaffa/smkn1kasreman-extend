<?php

namespace App\Livewire;

use App\Models\Unit;
use Livewire\Component;

class UnitDetail extends Component
{
    public $unitDetail;

    public function mount($slug)
    {
        $unit = Unit::where('slug', $slug)->first();
        
        if($unit) {
            $this->unitDetail = $unit;
        } else {
            abort(404);
        }

        $this->dispatch('title', title: $this->unitDetail->name);
    }

    public function render()
    {
        return view('livewire.unit-detail')->title($this->unitDetail->name);
    }
}
