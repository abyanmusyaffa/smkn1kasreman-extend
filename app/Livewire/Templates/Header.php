<?php

namespace App\Livewire\Templates;

use App\Models\BusinessUnit;
use App\Models\Extracurricular;
use App\Models\School;
use App\Models\TeachingFactory;
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
            'osis_slug' => Extracurricular::where('name', 'like', '%osis%')->value('slug'),
            'osis_name' => Extracurricular::where('name', 'like', '%osis%')->value('name'),
            'webLinks' => Weblink::all(),
            'teaching_factories' => TeachingFactory::select('name', 'slug')->get(),
            'business_units' => BusinessUnit::select('name', 'slug')->get(),
        ]);
    }
}
