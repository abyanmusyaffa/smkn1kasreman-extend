<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-slate-100">
  <!-- announ -->
  <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
    <!-- pinned -->
    @if($enrollmentPinned)
      <livewire:components.pinned-article :slug="$enrollmentPinned->slug" :createdAt="$enrollmentPinned->created_at" :title="$enrollmentPinned->title" :content="$enrollmentPinned->content" :photo="$enrollmentPinned->photo" />
    @endif
    <!-- pinned -->

    <!-- all announ -->
    <div data-aos="fade-up" class="flex flex-col gap-4 w-full justify-center">
      <livewire:components.title-left text="Informasi " span="PPDB" />

      <livewire:components.paginate :onEnrollments="true" />
    </div>
    <!-- all announ -->
  </article>
  <!-- announ -->
</div>