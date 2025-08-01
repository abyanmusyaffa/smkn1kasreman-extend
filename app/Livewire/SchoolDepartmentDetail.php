<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\SchoolDepartment;

class SchoolDepartmentDetail extends Component
{   
    public $schoolDepartmentDetail;

    public function mount($slug)
    {
        $schoolDepartment = SchoolDepartment::where('slug', $slug)->first();
        
        if($schoolDepartment) {
            $this->schoolDepartmentDetail = $schoolDepartment;
        } else {
            abort(404);
        }

        $this->dispatch('title', title: $this->schoolDepartmentDetail->name);
    }

    public function render()
    {
        return view('livewire.school-department-detail')->title($this->schoolDepartmentDetail->name);
    }
}
