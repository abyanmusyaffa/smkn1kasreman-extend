<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\Title;

class Enrollment extends Component
{
    #[Title('Informasi PPDB')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Informasi SPMB');
    }
    
    public function render()
    {
        return view('livewire.enrollment', [
            'enrollmentPinned' => Article::where('category', 'enrollment')->where('is_pinned', true)->first(),
        ]);
    }
}
