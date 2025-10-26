<?php

namespace App\Livewire;

use App\Models\Major;
use App\Models\Staff;
use App\Models\School;
use Livewire\Component;
use App\Models\Facility;
use Livewire\Attributes\Title;
use App\Models\Extracurricular;
use App\Models\SchoolLeadership;

class About extends Component
{
    #[Title('Tentang Sekolah')]

    
    public function mount()
    {
        $this->dispatch('title', title: 'Tentang Sekolah');
    }
    
    public function render()
    {
        return view('livewire.about', [
            'head_master' => SchoolLeadership::with('staff')->where('category', 'head-master')->first(),
            'school' => $school = School::first(),
            'profile_video_id' => $this->getYoutubeVideoId($school->url_video_profile),
            'total_students' => Major::sum('total_students'),
            'total_teachers' => Staff::where('category', 'teacher')->count(),
            'total_staff' => Staff::where('category', 'staff')->count(),
            'total_majors' => Major::count(),
            'total_extracurriculars' => Extracurricular::count(),
        ]);
    }

    private function getYoutubeVideoId(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        preg_match(
            '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $url,
            $matches
        );

        return $matches[1] ?? null;
    }
}
