<?php

namespace App\Livewire\Templates;

use Livewire\Component;

class MenuWeb extends Component
{
    public $title;
    public $school;
    public $osis_slug;
    public $osis_name;
    public $web_links;
    public $teaching_factories;
    public $business_units;
    public $school_departments;
    public $school_programs;

    public function render()
    {
        return view('livewire.templates.menu-web');
    }
}
