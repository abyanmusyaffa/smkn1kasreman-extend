<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
  <livewire:components.title-left text="Informasi " span="SPMB" />
  <!-- announ -->
  <!-- pinned -->
  @if($enrollmentPinned)
  <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
    <livewire:components.pinned-article :slug="$enrollmentPinned->slug" :created_at="$enrollmentPinned->created_at" :title="$enrollmentPinned->title" :content="$enrollmentPinned->content" :photo="$enrollmentPinned->photo" :category="$enrollmentPinned->category" />
  </article>
  @endif
  <!-- pinned -->

  <!-- all announ -->
  <aside  data-aos="fade-up" class="flex flex-col gap-4 w-full justify-center p-2 lg:p-4 rounded-2xl bg-white">
    <livewire:components.paginate :onEnrollments="true" />
  </aside>
  <!-- all announ -->
  <!-- announ -->
</div>