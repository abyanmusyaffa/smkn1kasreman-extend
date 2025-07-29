<?php

namespace App\Livewire\Components;

use App\Models\Article;
use App\Models\Partner;
use Livewire\Component;
use App\Models\Achievement;
use App\Models\BusinessUnit;
use App\Models\Extracurricular;
use App\Models\Jobfair;
use App\Models\StudentEvent;
use App\Models\TeachingFactory;
use App\Models\Testimonial;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Paginate extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $onAchievements;
    public $onPartners;
    public $onTeachingFactories;
    public $onBusinessUnits;
    public $onStudentEvents;
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

    public function render()
    {
        return view('livewire.components.paginate', [
            'achievements' => $this->onAchievements ? $this->getAchievements() : [],
            'partners' => $this->onPartners ? $this->getPartners() : [],
            'teachingFactories' => $this->onTeachingFactories? $this->getTeachingFactories() : [],
            'businessUnits' => $this->onBusinessUnits? $this->getBusinessUnits() : [],
            'studentEvents' => $this->onStudentEvents? $this->getStudentEvents() : [],
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

    private function getTeachingFactories()
    {
        return TeachingFactory::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();
    }

    private function getBusinessUnits()
    {
        return BusinessUnit::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();
    }

    private function getStudentEvents()
    {
        return StudentEvent::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(12);
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
        return Testimonial::with(['alumnis:id,name,photo,passing_year'])
            ->where('is_published', true)
            ->where('type', 'text')
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
