<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\Achievement as AchievementModel;
use Livewire\WithoutUrlPagination;

class Achievement extends Component
{
    #[Title('Prestasi')]

    
    public function mount()
    {
        $this->dispatch('title', title: 'Prestasi');
    }

    use WithPagination, WithoutUrlPagination;
    
    public function render()
    {
        return view('livewire.achievement', [
            'achievementsPinned' => AchievementModel::where('is_pinned', true)->get(),
        ]);
    }
}
