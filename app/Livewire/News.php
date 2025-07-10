<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\Title;

class News extends Component
{
    #[Title('Berita')]
    
    public function mount()
    {
        $this->dispatch('title', title: 'Berita');
    }
    
    public function render()
    {
        return view('livewire.news', [
            'newsPinned' => Article::where('category', 'news')->where('is_published', true)->where('is_pinned', true)->get()
        ]);
    }
}
