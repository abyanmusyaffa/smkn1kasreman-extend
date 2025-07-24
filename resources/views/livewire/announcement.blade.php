<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
  <livewire:components.title-left text="Pengumuman" />
  <!-- announ -->
  <!-- pinned -->
  @if($announcementPinned)
  <aside class="flex w-full flex-col gap-4 lg:gap-6 items-center">
    <livewire:components.pinned-article :slug="$announcementPinned->slug" :created_at="$announcementPinned->created_at" :title="$announcementPinned->title" :content="$announcementPinned->content" :photo="$announcementPinned->photo" :category="$announcementPinned->category" />
  </aside>
  @endif
  <!-- pinned -->

  <!-- all announ -->
  <article data-aos="fade-up" class="flex flex-col gap-4 w-full justify-center p-2 lg:p-4 rounded-2xl bg-white">
    <livewire:components.paginate :onAnnouncements="true" />
  </article>
  <!-- all announ -->
  <!-- announ -->
</div>