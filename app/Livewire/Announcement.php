<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\Title;

class Announcement extends Component
{
    #[Title('Pengumuman')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Pengumuman');
    }
    
    public function render()
    {
        return view('livewire.announcement', [
            'announcementPinned' => Article::where('category', 'announcement')->where('is_published', true)->where('is_pinned', true)->first(),
        ]);
    }
}
