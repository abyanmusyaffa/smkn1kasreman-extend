<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col lg:flex-row gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <aside class="flex flex-col items-center lg:w-1/4 gap-4 lg:gap-6">
        <div class="flex flex-col items-center w-full bg-white h-fit rounded-2xl p-4 lg:p-8 gap-2">
            <img data-fancybox src="/storage/{{ $majorDetail->logo }}" class="w-1/3 lg:w-2/5 " alt="">
            <div class="px-2 py-0.5 border border-blue-600 rounded-lg">
                <p class="text-xs text-blue-800 font-semibold">{{ $majorDetail->alias }}</p>
            </div>
            <h2 class="font-semibold text-xl lg:text-2xl leading-none text-slate-700 text-center">{{ $majorDetail->expertise_concentration }}</h2>
            <p class="text-slate-500 italic text-center text-xs">{{ $majorDetail->expertise_program}}</p>
            @if($majorDetail->contacts)
            <div class="w-fit flex gap-2">
                @foreach($majorDetail->contacts as $contact)
                    <a href="{{ $contact['url'] }}" class="flex justify-center items-center size-6 lg:size-8 rounded-md bg-blue-600">
                        <span @class([
                            'text-sm lg:text-lg text-slate-50', 
                            'icon-[mingcute--whatsapp-fill]' => $contact['platform'] === 'whatsapp', 
                            'icon-[mingcute--mail-ai-fill]' => $contact['platform'] === 'email', 
                            'icon-[mingcute--ins-fill]' => $contact['platform'] === 'instagram', 
                            'icon-[mingcute--facebook-fill]' => $contact['platform'] === 'facebook', 
                            'icon-[mingcute--tiktok-fill]' => $contact['platform'] === 'tiktok', 
                            'icon-[mingcute--youtube-fill]' => $contact['platform'] === 'youtube', 
                            ])>
                        </span>
                    </a>
                @endforeach
            </div>
            @endif
        </div>
        <div class="flex w-full bg-white h-fit rounded-2xl p-4 lg:p-8 gap-2 lg:gap-4 justify-between">
            <div class="flex flex-col gap-1 lg:gap-2 items-center">
                <div class="size-7 lg:size-8 rounded-lg bg-blue-400 grid place-items-center">
                    <span class="icon-[mdi--group] text-slate-50 lg:text-lg"></span>
                </div>
                <p class="text-slate-800 text-sm text-center font-medium">{{ $majorDetail->study_group }} Rombel</p>
            </div>
            <div class="flex flex-col gap-1 lg:gap-2 items-center">
                <div class="size-7 lg:size-8 rounded-lg bg-blue-400 grid place-items-center">
                    <span class="icon-[mdi--clock-outline] text-slate-50 lg:text-lg"></span>
                </div>
                <p class="text-slate-800 text-sm text-center font-medium">{{ $majorDetail->study_period }} Tahun Belajar</p>
            </div>
            <div class="flex flex-col gap-1 lg:gap-2 items-center">
                <div class="size-7 lg:size-8 rounded-lg bg-blue-400 grid place-items-center">
                    <span class="icon-[ph--student] text-slate-50 lg:text-lg"></span>
                </div>
                <p class="text-slate-800 text-sm text-center font-medium">{{ $majorDetail->total_students }} Siswa</p>
            </div>
        </div>
    </aside>
    <article class="flex flex-col gap-4 lg:gap-6 items-center w-full lg:w-3/4">
        <div class="flex flex-col bg-white rounded-2xl w-full p-4 lg:p-8">
            <div id="rich-content" class="prose lg:prose-figure:w-2/3 lg:prose-figure:mx-auto w-full max-w-none">
                {!! $majorDetail->description !!}
            </div>
        </div>
    </article>
</div>