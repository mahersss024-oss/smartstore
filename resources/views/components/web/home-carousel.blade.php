<!-- Home Carousel -->
@if($banners->count() > 0)
    <div
        x-data="{
            nextSlide: function (){
                this.currentSlide === this.totalSlides ? this.currentSlide = 1 : this.currentSlide++
            },
            prevSlide: function() {
              this.currentSlide === 1 ? this.currentSlide = this.totalSlides : this.currentSlide--
            },
            currentSlide: 1,
            totalSlides: {{ $banners->count() }}
        }"
        x-cloak
        class="relative"
    >
        @foreach($banners as $key => $banner)
            <img
                x-show="currentSlide === {{ $key + 1 }}"
                src="{{ $banner->getFirstMediaUrl() }}"
                class="h-40 w-full object-fill sm:h-60 md:h-80 lg:h-96 xl:h-[28rem]"
                alt="{{ $banner->seo_title }}"
            />
        @endforeach

        @if($banners->count() > 1)
            <button @click="prevSlide()" class="absolute top-1/2 left-4 -translate-y-1/2 transform">
                <x-icon
                    :name="'heroicon-s-chevron-left'"
                    class="h-6 w-6"
                />
            </button>

            <button @click="nextSlide()" class="absolute top-1/2 right-4 -translate-y-1/2 transform">
                <x-icon
                    :name="'heroicon-s-chevron-right'"
                    class="h-6 w-6"
                />
            </button>
        @endif
    </div>
@endif
