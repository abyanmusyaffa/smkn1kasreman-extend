<div>
    @if($isOpen)
    <div wire:click="close" class="fixed inset-0 flex px-2 py-10 justify-center items-center bg-slate-900 bg-opacity-50 z-50">
        <div wire:click.stop class="flex flex-col w-full lg:w-1/2 h-full bg-slate-100 rounded-2xl p-4 lg:p-6 items-center gap-4">
            <div class="flex w-full items-center justify-between">
                <div class="flex flex-col">
                    <div class="flex items-center gap-1 lg:gap-2">
                        <div class="h-0.5 w-4 lg:w-6 bg-slate-700"></div>
                        <img src="/storage/{{ $logo }}" class="w-4" alt="">
                        <p class="font-medium text-sm lg:text-base text-slate-700">{{ $alias }}</p>
                        <div class="h-0.5 w-4 lg:w-6 bg-slate-700"></div>
                    </div>
                    <h3 class="font-semibold text-xl lg:text-3xl text-slate-800">{{ $expertise_concentration }}</h3>
                </div>
                <button wire:click="close" class="">
                    <span class="icon-[mdi--close] text-4xl text-slate-400"></span>
                </button>
            </div>
            <div class="scroll-bar-none flex size-full rounded-xl bg-white p-4 overflow-y-scroll">
                <article class="prose lg:prose-figure:w-2/3">
                    {!! $description !!}
                </article>
            </div>
        </div>
    </div>
    @endif
</div>