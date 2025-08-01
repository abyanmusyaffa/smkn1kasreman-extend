<?php

namespace App\Livewire;

use App\Models\OrganizationalStructure as ModelsOrganizationalStructure;
use Livewire\Component;
use Livewire\Attributes\Title;

class OrganizationalStructure extends Component
{
    #[Title('Struktur Organisasi')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Struktur Organisasi');
    }

    public function render()
    {
        return view('livewire.organizational-structure', [
            // 'headMaster' => StaffModel::where('category', 'head-master')->first(), 
            // 'viceMasters' => StaffModel::where('category', 'vice-master')->get(),
            // 'headsOfMajor' => StaffModel::where('category', 'head-of-major')->get(),
            'organizational_structures' => ModelsOrganizationalStructure::all(),
            // 'teachers' => StaffModel::where('category', 'teacher')->orderBy('role')->get(),
            // 'staff_members' => StaffModel::where('category', 'staff')->orderBy('role')->get(),
        ]);
    }
}
