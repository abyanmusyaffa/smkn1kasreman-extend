<?php

namespace App\Livewire;

use App\Models\BusinessUnit;
use Livewire\Component;

class BusinessUnitDetail extends Component
{
    public $businessUnitDetail;

    public function mount($slug)
    {
        $businessUnit = BusinessUnit::where('slug', $slug)->first();
        
        if($businessUnit) {
            $this->businessUnitDetail = $businessUnit;
        } else {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.business-unit-detail')->title($this->businessUnitDetail->name);
    }
}
