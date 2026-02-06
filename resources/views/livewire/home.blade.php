<div class="min-h-screen bg-white">
    {{-- Single Clean Navigation Bar --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                {{-- Left: Logo + Branding --}}
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Dharamshala Connect</h1>
                        <p class="text-xs text-gray-600">Shree Ram Trust</p>
                    </div>
                </div>

                {{-- Right: Navigation + Language Switcher --}}
                <div class="flex items-center space-x-6">
                    <a href="/"
                        class="text-sm font-semibold text-blue-600 border-b-2 border-blue-600 pb-1">{{ trans_db('home') }}</a>
                    <a href="/book"
                        class="text-sm font-medium text-gray-700 hover:text-blue-600 transition">{{ trans_db('book_now') }}</a>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <a href="/login"
                        class="text-sm font-medium text-gray-700 hover:text-blue-600 transition">{{ trans_db('staff_login') }}</a>

                    {{-- Language Switcher --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition border border-gray-300 rounded-lg hover:border-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                </path>
                            </svg>
                            <span>
                                @if(app()->getLocale() == 'en') English
                                @elseif(app()->getLocale() == 'hi') हिंदी
                                @elseif(app()->getLocale() == 'gu') ગુજરાતી
                                @elseif(app()->getLocale() == 'te') తెలుగు
                                @elseif(app()->getLocale() == 'ta') தமிழ்
                                @endif
                            </span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                            <a href="/lang/en"
                                class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition">
                                <span class="flex items-center space-x-2">
                                    <span>🇺🇸</span>
                                    <span>English</span>
                                </span>
                                @if(app()->getLocale() == 'en')
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </a>
                            <a href="/lang/hi"
                                class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition">
                                <span class="flex items-center space-x-2">
                                    <span>🇮🇳</span>
                                    <span>हिंदी</span>
                                </span>
                                @if(app()->getLocale() == 'hi')
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </a>
                            <a href="/lang/gu"
                                class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition">
                                <span class="flex items-center space-x-2">
                                    <span>🦁</span>
                                    <span>ગુજરાતી</span>
                                </span>
                                @if(app()->getLocale() == 'gu')
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </a>
                            <a href="/lang/mr"
                                class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition">
                                <span class="flex items-center space-x-2">
                                    <span>🚩</span>
                                    <span>मराठी</span>
                                </span>
                                @if(app()->getLocale() == 'mr')
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </a>
                            <a href="/lang/te"
                                class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition">
                                <span class="flex items-center space-x-2">
                                    <span>🕉️</span>
                                    <span>తెలుగు</span>
                                </span>
                                @if(app()->getLocale() == 'te')
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </a>
                            <a href="/lang/ta"
                                class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition">
                                <span class="flex items-center space-x-2">
                                    <span>🐅</span>
                                    <span>தமிழ்</span>
                                </span>
                                @if(app()->getLocale() == 'ta')
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <div class="relative h-[600px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero.png') }}" alt="Dharamshala Hero" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                {{ trans_db('welcome_title') }}
            </h1>
            <p class="text-lg md:text-xl text-blue-50 mb-10 leading-relaxed">
                {{ trans_db('welcome_subtitle') }}
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/book"
                    class="px-8 py-4 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    {{ trans_db('book_now') }}
                </a>
                <a href="#rooms"
                    class="px-8 py-4 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    {{ trans_db('explore_rooms') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Features Section --}}
    <div class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ trans_db('features_title') }}</h2>
                <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
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

                <div
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

                <div
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