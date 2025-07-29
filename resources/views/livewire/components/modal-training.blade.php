<div>
    @if($isOpen)
    <div wire:click="close" class="fixed inset-0 flex px-2 py-10 justify-center items-center bg-slate-900 bg-opacity-50 z-50">
        <div wire:click.stop class="flex flex-col w-full lg:w-1/2 h-full bg-slate-100 rounded-2xl p-4 lg:p-6 items-center gap-4">
            <div class="flex w-full items-center justify-between">
                <h3 class="font-semibold text-xl lg:text-3xl text-slate-800">{{ $name }}</h3>
                <button wire:click="close" class="">
                    <span class="icon-[mdi--close] text-4xl text-slate-400"></span>
                </button>
            </div>
            <div class="scroll-bar-none flex size-full rounded-xl bg-white p-4 overflow-y-scroll">
                <article id="rich-content" class="prose lg:prose-figure:w-2/3">
                    {!! $description !!}
                </article>
            </div>
            <a href="{{ $url }}" target="_blank" class="rounded-lg bg-green-500 py-1 px-4 text-slate-50 w-fit self-end transition-all duration-200 hover:bg-green-600">
                <p>Daftar</p>
            </a>
        </div>
    </div>
    @endif
</div>