<?php

namespace App\Livewire\Components;

use App\Models\Article;
use App\Models\Partner;
use Livewire\Component;
use App\Models\Achievement;
use App\Models\Jobfair;
use App\Models\Testimonial;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Paginate extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $onPartners;
    public $onTestimonials;
    public $onAchievements;
    public $onAnnouncements;
    public $onEnrollments;
    public $onNews;
    public $onJobfairs;

    public function render()
    {
        return view('livewire.components.paginate', [
            'achievements'=> $this->onAchievements ? Achievement::orderBy('updated_at', 'desc')->paginate(12) : [],
            'partners' =>  $this->onPartners ? Partner::orderBy('updated_at', 'desc')->paginate(12) : [] ,
            'testimonials' => $this->onTestimonials ? Testimonial::with('alumnis')->where('show', true)->orderBy('created_at', 'desc')->paginate(12) : [] ,
            'news' => $this->onNews ? Article::where('category', 'news')->orderBy('updated_at', 'desc')->paginate(12) : [] ,
            'announcements' => $this->onAnnouncements ? Article::where('category', 'announcement')->where('is_pinned', false)->orderBy('updated_at', 'desc')->paginate(12) : [] ,
            'enrollments' => $this->onEnrollments ? Article::where('category', 'enrollment')->where('is_pinned', false)->orderBy('updated_at', 'desc')->paginate(12) : [] ,
            'jobfairs' => $this->onJobfairs ? Jobfair::where('show', true)->orderBy('updated_at', 'desc')->paginate(12) : [] ,
        ]);
    }
}
