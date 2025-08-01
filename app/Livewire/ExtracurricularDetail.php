<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Extracurricular;

class ExtracurricularDetail extends Component
{
    public $extracurricularDetail;

    public function mount($slug)
    {
        $extracurricular = Extracurricular::where('slug', $slug)->first();
        
        if($extracurricular) {
            $this->extracurricularDetail = $extracurricular;
        } else {
            abort(404);
        }

        $this->dispatch('title', title: $this->extracurricularDetail ->name);
    }

    public function render()
    {
        return view('livewire.extracurricular-detail')->title($this->extracurricularDetail->name);
    }
}
