<?php

namespace App\Livewire;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\Attributes\Title;

class Alumni extends Component
{
    #[Title('Cerita Alumni')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Cerita Alumni');
    }
    
    public function render()
    {
        return view('livewire.alumni', [
            'testimonialVideo' => Testimonial::with(['alumnis:id,name,photo,passing_year'])->where('type', 'url')->where('is_published', 'true')->latest()->get(),
        ]);
    }
}
