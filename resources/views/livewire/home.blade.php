<div class="min-h-screen bg-white">

    {{-- Dynamic Hero Slider --}}
    <div class="relative h-[650px] flex items-center justify-center overflow-hidden bg-slate-900" x-data="{ 
            active: 0, 
            slides: [
                { image: '{{ asset('images/slider-1.png') }}', title: '{{ trans_db('welcome_title') }}', subtitle: '{{ trans_db('welcome_subtitle') }}' },
                { image: '{{ asset('images/slider-2.png') }}', title: 'Spiritual Serenity', subtitle: 'Experience the divine atmosphere in our sacred halls.' },
                { image: '{{ asset('images/slider-3.png') }}', title: 'Modern Comfort', subtitle: 'Traditional hospitality blended with modern amenities.' }
            ],
            next() { this.active = (this.active + 1) % this.slides.length },
            prev() { this.active = (this.active - 1 + this.slides.length) % this.slides.length }
         }" x-init="setInterval(() => next(), 6000)">

        {{-- Slides --}}
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="active === index" x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0 scale-110" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" class="absolute inset-0 z-0">
                <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 bg-gradient-to-b from-black/20 via-transparent to-black/60">
                </div>
            </div>
        </template>

        {{-- Content Overlay --}}
        <div class="relative z-10 text-center px-4 max-w-5xl mx-auto">
            <template x-for="(slide, index) in slides" :key="'content-' + index">
                <div x-show="active === index" x-transition:enter="transition ease-out delay-500 duration-1000"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <h1 class="text-5xl md:text-7xl font-black text-white mb-8 leading-tight tracking-tight"
                        x-text="slide.title"></h1>
                    <p class="text-xl md:text-2xl text-blue-50 mb-12 leading-relaxed opacity-90 max-w-3xl mx-auto font-light"
                        x-text="slide.subtitle"></p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                        <a href="/book"
                            class="px-10 py-5 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 transition shadow-2xl shadow-blue-500/20 transform hover:-translate-y-1 active:scale-95">
                            {{ trans_db('book_now') }}
                        </a>
                        <a href="#rooms"
                            class="px-10 py-5 bg-white/10 backdrop-blur-md text-white border border-white/30 font-bold rounded-2xl hover:bg-white/20 transition shadow-xl transform hover:-translate-y-1 active:scale-95">
                            {{ trans_db('explore_rooms') }}
                        </a>
                    </div>
                </div>
            </template>
        </div>

        {{-- Slider Navigation --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 flex space-x-3">
            <template x-for="(slide, index) in slides" :key="'dot-' + index">
                <button @click="active = index" class="w-3 h-3 rounded-full transition-all duration-500"
                    :class="active === index ? 'bg-white w-8 shadow-lg' : 'bg-white/30 hover:bg-white/50'"></button>
            </template>
        </div>
    </div>

    {{-- Features Section --}}
    <div class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ trans_db('features_title') }}</h2>
                <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8" x-data="{ show: false }"
                x-init="setTimeout(() => show = true, 300)">
                <div x-show="show" x-transition:enter="transition ease-out duration-1000 delay-100"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition group text-center">
                    <div
                        class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ trans_db('clean_comfortable') }}</h3>
                    <p class="text-gray-600 leading-relaxed">We maintain the highest standards of hygiene and comfort
                        for all our guests.</p>
                </div>

                <div x-show="show" x-transition:enter="transition ease-out duration-1000 delay-300"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition group text-center">
                    <div
                        class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ trans_db('affordable_rates') }}</h3>
                    <p class="text-gray-600 leading-relaxed">Our pricing is transparent and designed to be accessible
                        for everyone.</p>
                </div>

                <div x-show="show" x-transition:enter="transition ease-out duration-1000 delay-500"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition group text-center">
                    <div
                        class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ trans_db('24_7_support') }}</h3>
                    <p class="text-gray-600 leading-relaxed">Our friendly staff is always here to assist you during your
                        stay.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- About Section --}}
    <div class="py-20 bg-blue-600 text-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="flex-1">
                    <h2 class="text-3xl font-bold mb-6">{{ trans_db('about_us_title') }}</h2>
                    <p class="text-xl leading-relaxed opacity-90 mb-8">
                        {{ trans_db('about_us_text') }}
                    </p>
                    <div class="flex items-center space-x-6">
                        <div class="flex flex-col">
                            <span class="text-3xl font-bold">50+</span>
                            <span class="text-sm opacity-70">Rooms</span>
                        </div>
                        <div class="h-10 w-px bg-white bg-opacity-30"></div>
                        <div class="flex flex-col">
                            <span class="text-3xl font-bold">10k+</span>
                            <span class="text-sm opacity-70">Happy Guests</span>
                        </div>
                        <div class="h-10 w-px bg-white bg-opacity-30"></div>
                        <div class="flex flex-col">
                            <span class="text-3xl font-bold">4.8/5</span>
                            <span class="text-sm opacity-70">Rating</span>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1544644181-1484b3fdfc62?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                            alt="About Image" class="rounded-2xl shadow-2xl">
                        <div
                            class="absolute -bottom-6 -right-6 w-32 h-32 bg-yellow-400 rounded-2xl flex items-center justify-center shadow-xl">
                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Location Section --}}
    <div class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-12">{{ trans_db('locations_title') }}</h2>
            <div
                class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg border border-gray-100 flex flex-col md:flex-row items-center gap-8">
                <div class="flex-1 text-left">
                    <h3 class="text-xl font-bold mb-4 text-blue-600">Dharamshala Connect</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        {{ \App\Models\Setting::get('contact_address', '123 Spiritual Pathway, Spiritual District, Dharamshala, HP 176215') }}
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 text-gray-700">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span>{{ \App\Models\Setting::get('contact_phone', '+91 98765 43210') }}</span>
                        </div>
                        <div class="flex items-center space-x-3 text-gray-700">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>{{ \App\Models\Setting::get('contact_email', 'info@dharamshalaconnect.com') }}</span>
                        </div>
                    </div>
                </div>
                <div
                    class="flex-1 w-full h-64 bg-gray-200 rounded-xl overflow-hidden shadow-inner flex items-center justify-center">
                    <span class="text-gray-400 italic">Google Maps Integrated Here</span>
                </div>
            </div>
        </div>
    </div>
</div>