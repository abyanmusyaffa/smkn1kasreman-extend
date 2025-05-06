<?php

namespace App\Livewire;

use App\Models\Staff as StaffModel;
use Livewire\Component;
use Livewire\Attributes\Title;

class Staff extends Component
{
    #[Title('GTK')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'GTK');
    }

    public function render()
    {
        return view('livewire.staff', [
            'headMaster' => StaffModel::where('category', 'head-master')->first(), 
            'viceMasters' => StaffModel::where('category', 'vice-master')->get(),
            'headsOfMajor' => StaffModel::where('category', 'head-of-major')->get(),
            'teachers' => StaffModel::where('category', 'teacher')->get(),
            'staffMembers' => StaffModel::where('category', 'staff')->get(),
        ]);
    }
}
