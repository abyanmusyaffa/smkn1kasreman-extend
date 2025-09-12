<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SchoolProgram;

class SchoolProgramDetail extends Component
{
    public $schoolProgramDetail;

    public function mount($slug)
    {
        $schoolProgram = SchoolProgram::where('slug', $slug)->first();
        
        if($schoolProgram) {
            $this->schoolProgramDetail = $schoolProgram;
        } else {
            abort(404);
        }

        $this->dispatch('title', title: $this->schoolProgramDetail->name);
    }

    public function render()
    {
        return view('livewire.school-program-detail')->title($this->schoolProgramDetail->name);
    }
}
