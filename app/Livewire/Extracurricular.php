<?php

namespace App\Livewire;

use App\Models\Extracurricular as ExtracurricularModel;
use Livewire\Component;
use Livewire\Attributes\Title;

class Extracurricular extends Component
{
    #[Title('Ekstrakurikuler')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Ekstrakurikuler');
    }

    public function render()
    {
        return view('livewire.extracurricular', [
            'extracurriculars' => ExtracurricularModel::all(),
        ]);
    }
}
