{{-- @dd($jobfairs, $articles, $achievements) --}}
<aside class="flex w-full flex-col lg:w-1/3 h-fit rounded-2xl p-2 lg:p-4 bg-white gap-4">
    <header>
        <h3 class="font-semibold lg:text-xl text-slate-700 text-center">
            @if($articles && $articles->count() > 0)
                @if($articles->first()->category === 'news')
                    Berita
                @elseif($articles->first()->category === 'announcement')
                    Pengumuman
                @elseif($articles->first()->category === 'enrollment')
                    Informasi SPMB
                @endif
            @elseif($achievements && $achievements->count() > 0)
                Prestasi
            @elseif($jobfairs && $jobfairs->count() > 0)
                Lowongan
            @endif
             Lainnya
        </h3>
    </header>
    <div class="flex flex-col gap-2 ">
        @if($articles && $articles->count() > 0) 
            @foreach($articles as $article)
                <livewire:components.aside-card-article wire:key="{{ $article->id }}" :slug="$article->slug" :title="$article->title" :photo="$article->photo" :category="$article->category"  :createdAt="$article->created_at"   />
            @endforeach
        @elseif($achievements && $achievements->count() > 0)
            @foreach($achievements as $achievement)
                <livewire:components.aside-card-achievement wire:key="{{ $achievement->id }}" :slug="$achievement->slug" :title="$achievement->title" :photo="$achievement->photo" :rankings="$achievement->rankings"  :createdAt="$achievement->created_at"   />
            @endforeach
        @elseif($jobfairs && $jobfairs->count() > 0)
            @foreach($jobfairs as $jobfair)
                <livewire:components.aside-card-jobfair wire:key="{{ $jobfair->id }}" :slug="$jobfair->slug" :title="$jobfair->title" :photo="$jobfair->photo" :deadline="$jobfair->deadline"   />
            @endforeach
        @endif
    </div>
</aside>
