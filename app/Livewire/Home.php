<?php

namespace App\Livewire;

use App\Models\Major;
use App\Models\Photo;
use App\Models\Staff;
use App\Models\School;
use App\Models\Article;
use App\Models\Partner;
use Livewire\Component;
use App\Models\Achievement;
use App\Models\Gallery;
use App\Models\Testimonial;
use Livewire\Attributes\Title;

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
            'announcement_text' => Article::whereIn('category', ['announcement', 'enrollment'])->where('is_headline', true)->select('title', 'slug', 'category')->first(),
            'school' => $school = School::first(),
            'summary' => $this->getFirstParagraph(),
            'welcome_video_id' => $this->getYoutubeVideoId($school->url_video_welcome),
            'head_master' => Staff::where('category', 'head-master')->value('name'),
            'galleries' => collect(Gallery::value('galleries') ?? [])->take(6),
            'partners' => Partner::where('logo', 'NOT LIKE', '%default%')->pluck('logo'),
            'achievements' => Achievement::latest()->take(4)->get(['id', 'photo', 'slug', 'rankings', 'title', 'created_at']),
            'latest_article' => Article::latest()->take(1)->value('updated_at'),
            'articles' => Article::where('is_published', true)->latest()->take(6)->get(['id', 'photo', 'slug', 'category', 'title', 'created_at']),
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
