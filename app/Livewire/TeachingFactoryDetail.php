<?php

namespace App\Livewire;

use App\Models\TeachingFactory;
use Livewire\Component;

class TeachingFactoryDetail extends Component
{
    public $teachingFactoryDetail;

    public function mount($slug)
    {
        $teachingFactory = TeachingFactory::where('slug', $slug)->first();
        
        if($teachingFactory) {
            $this->teachingFactoryDetail = $teachingFactory;
        } else {
            abort(404);
        }

        $this->dispatch('title', title: $this->teachingFactoryDetail->name);
    }

    public function render()
    {
        return view('livewire.teaching-factory-detail')->title($this->teachingFactoryDetail->name);
    }
}
