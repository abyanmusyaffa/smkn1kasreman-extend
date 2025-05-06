<?php

namespace App\Livewire\Templates;

use App\Models\School;
use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        return view('livewire.templates.footer', [
            'school' => School::select('name', 'logo', 'address', 'phone', 'email', 'url_instagram', 'url_facebook', 'url_youtube', 'url_tiktok')->first(),
        ]);
    }
}
