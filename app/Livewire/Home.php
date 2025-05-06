<?php

namespace App\Livewire;

use App\Models\Achievement;
use App\Models\Article;
use App\Models\Major;
use App\Models\Partner;
use App\Models\Photo;
use App\Models\School;
use App\Models\Testimonial;
use Livewire\Attributes\Title;
use Livewire\Component;

class Home extends Component
{
    #[Title('Beranda')]

    public function mount()
    {
        $this->dispatch('title', title: 'Beranda');
    }
    
    public function getFirstParagraph()
    {
        $description = School::value('description');

        if (empty($description)) {
            return '';
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $paragraphs = $dom->getElementsByTagName('p');
        if ($paragraphs->length > 0) {
            return trim($paragraphs->item(0)->nodeValue);
        }

        return '';
    }

    public function render()
    {
        return view('livewire.home', [
            'majors' => Major::select('id', 'expertise_concentration', 'alias', 'logo')->get(),
            'school' => School::first(),
            'summary' => $this->getFirstParagraph(),
            'video_id' => $this->getYoutubeVideoId(School::first()->url_video_profile),
            'heros' => Photo::where('type', 'hero')->value('photo'),
            'galleries' => Photo::where('type', 'gallery')->value('photo'),
            'partners' => Partner::where('logo', 'NOT LIKE', '%default%')->pluck('logo'),
            'achievements' => Achievement::orderBy('created_at', 'desc')->take(4)->get(),
            'testimonials' => Testimonial::with('alumnis')->where('show', true)->orderBy('created_at', 'desc')->take(6)->get(),
            'articles' => Article::orderBy('created_at', 'desc')->take(4)->get(),
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
