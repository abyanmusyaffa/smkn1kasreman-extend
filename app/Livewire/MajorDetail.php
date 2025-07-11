<?php

namespace App\Livewire;

use App\Models\Major;
use Livewire\Component;

class MajorDetail extends Component
{
    public $majorDetail;

    public function mount($alias)
    {

        $major = Major::where('alias', strtoupper($alias))->first();
        
        if($major) {
            $this->majorDetail = $major;
        } else {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.major-detail')->title($this->majorDetail->expertise_concentration);
    }
}
