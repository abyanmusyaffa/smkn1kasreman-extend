<?php

namespace App\Livewire\Components;

use App\Models\Article;
use App\Models\Partner;
use Livewire\Component;
use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\Jobfair;
use App\Models\Testimonial;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Paginate extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $onAchievements;
    public $onPartners;
    public $onExtracurriculars;
    public $onTestimonials;
    public $onAnnouncements;
    public $onEnrollments;
    public $onNews;
    public $onJobfairs;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // public function render()
    // {
    //     return view('livewire.components.paginate', [
    //         'achievements'=> $this->onAchievements ? Achievement::orderBy('updated_at', 'desc')->paginate(12) : [],
    //         'partners' =>  $this->onPartners ? Partner::orderBy('updated_at', 'desc')->paginate(12) : [] ,
    //         'testimonials' => $this->onTestimonials ? Testimonial::with('alumnis')->where('show', true)->orderBy('created_at', 'desc')->paginate(12) : [] ,
    //         'news' => $this->onNews ? Article::where('category', 'news')->orderBy('updated_at', 'desc')->paginate(12) : [] ,
    //         'announcements' => $this->onAnnouncements ? Article::where('category', 'announcement')->where('is_pinned', false)->orderBy('updated_at', 'desc')->paginate(12) : [] ,
    //         'enrollments' => $this->onEnrollments ? Article::where('category', 'enrollment')->where('is_pinned', false)->orderBy('updated_at', 'desc')->paginate(12) : [] ,
    //         'jobfairs' => $this->onJobfairs ? Jobfair::where('show', true)->orderBy('updated_at', 'desc')->paginate(12) : [] ,
    //     ]);
    // }

    public function render()
    {
        return view('livewire.components.paginate', [
            'achievements' => $this->onAchievements ? $this->getAchievements() : [],
            'partners' => $this->onPartners ? $this->getPartners() : [],
            'extracurriculars' => $this->onExtracurriculars ? $this->getExtracurriculars() : [],
            'testimonials' => $this->onTestimonials ? $this->getTestimonials() : [],
            'news' => $this->onNews ? $this->getNews() : [],
            'announcements' => $this->onAnnouncements ? $this->getAnnouncements() : [],
            'enrollments' => $this->onEnrollments ? $this->getEnrollments() : [],
            'jobfairs' => $this->onJobfairs ? $this->getJobfairs() : [],
        ]);
    }

    private function getAchievements()
    {
        return Achievement::when($this->search, function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('rankings', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->paginate(12);
    }

    private function getPartners()
    {
        return Partner::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('industry', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->get();
    }

    private function getExtracurriculars()
    {
        return Extracurricular::where('name', 'not like', '%osis%')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();
    }

    private function getTestimonials()
    {
        return Testimonial::with('alumnis')
            ->where('show', true)
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('position', 'like', '%' . $this->search . '%')
                        ->orWhere('company', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%')
                        ->orWhereHas('alumnis', function ($alumniQuery) {
                            $alumniQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest()
            ->paginate(12);
    }

    private function getNews()
    {
        return Article::where('category', 'news')->where('is_published', true)
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(12);
    }

    private function getAnnouncements()
    {
        return Article::where('category', 'announcement')->where('is_published', true)
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(12);
    }

    private function getEnrollments()
    {
        return Article::where('category', 'enrollment')->where('is_published', true)
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(12);
    }

    private function getJobfairs()
    {
        return Jobfair::where('show', true)
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(12);
    }
}
