<?php

namespace App\Livewire;

use App\Models\Major;
use App\Models\Staff;
use App\Models\School;
use Livewire\Component;
use App\Models\Facility;
use Livewire\Attributes\Title;
use App\Models\Extracurricular;

class About extends Component
{
    #[Title('Tentang Sekolah')]

    
    public function mount()
    {
        $this->dispatch('title', title: 'Tentang Sekolah');
    }
    
    public function render()
    {
        return view('livewire.about', [
            'headMaster' => Staff::where('category', 'head-master')->first(), 
            'school' => School::first(),
            'facilities' => Facility::all(),
            'totalStudents' => Major::sum('total_students'),
            'totalTeachers' => Staff::where('category', 'teacher')->count(),
            'totalStaff' => Staff::where('category', 'staff')->count(),
            'totalMajors' => Major::count(),
            'totalExtracurriculars' => Extracurricular::count(),
        ]);
    }
}
