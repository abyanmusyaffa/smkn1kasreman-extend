<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Facility as FacilityModel;
use App\Models\School;
use Livewire\Attributes\Title;

class Facility extends Component
{
    #[Title('Sarana Prasarana')]

    
    public function mount()
    {
        $this->dispatch('title', title: 'Sarana Prasarana');
    }
    
    public function render()
    {
        return view('livewire.facility', [
            'infraFacilities' => FacilityModel::where('category', 'infrastructure')->get(),
            'learnFacilities' => FacilityModel::where('category', 'learning')->get(),
            'schoolMap' => School::first()->value('school_map'),
        ]);
    }
}
