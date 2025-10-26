<?php

namespace App\Livewire;

use App\Models\OrganizationalStructure;
use App\Models\SchoolLeadership;
use App\Models\Staff as StaffModel;
use Livewire\Component;
use Livewire\Attributes\Title;

class Staff extends Component
{
    #[Title('Guru & Tenaga Kependidikan')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Guru & Tenaga Kependidikan');
    }

    public function render()
    {
        return view('livewire.staff', [
            'head_master' => SchoolLeadership::with('staff')->where('category', 'head-master')->first(), 
            'vice_masters' => SchoolLeadership::with('staff')->where('category', 'vice-master')->get(),
            'head_of_majors' => SchoolLeadership::with('staff')->where('category', 'head-of-major')->get(),
            'teachers' => StaffModel::where('category', 'teacher')->orderBy('role')->get(),
            'staff_members' => StaffModel::where('category', 'staff')->orderBy('role')->get(),
        ]);
    }
}
