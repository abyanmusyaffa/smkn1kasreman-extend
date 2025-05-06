<?php

namespace App\Livewire\Templates;

use App\Models\School;
use App\Models\Weblink;
use Livewire\Component;

class Header extends Component
{
    public $title;

    protected $listeners = ['title' => 'title'];

    public function title($title)
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('livewire.templates.header', [
            'school' => School::select('name', 'logo', 'alias')->first(),
            'webLinks' => Weblink::all(),
        ]);
    }
}
