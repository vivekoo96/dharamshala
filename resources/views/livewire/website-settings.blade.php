<div>
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Website Settings</h1>
        <p class="text-sm text-gray-600 mt-1">Manage your website configuration and footer content</p>
    </div>

    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Settings --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- General Settings --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="settings" class="w-5 h-5 mr-2 text-blue-600"></i>
                    General Settings
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                        <input type="text" wire:model="settings.site_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Tagline</label>
                        <input type="text" wire:model="settings.site_tagline"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Description</label>
                        <textarea wire:model="settings.site_description" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="mail" class="w-5 h-5 mr-2 text-green-600"></i>
                    Contact Information
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" wire:model="settings.contact_phone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" wire:model="settings.contact_email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea wire:model="settings.contact_address" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
            </div>

            {{-- Social Media Links --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="link" class="w-5 h-5 mr-2 text-purple-600"></i>
                    Social Media Links
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                        <input type="url" wire:model="settings.social_facebook"
                            placeholder="https://facebook.com/yourpage"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Twitter URL</label>
                        <input type="url" wire:model="settings.social_twitter"
                            placeholder="https://twitter.com/yourhandle"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                        <input type="url" wire:model="settings.social_instagram"
                            placeholder="https://instagram.com/yourhandle"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
                        <input type="tel" wire:model="settings.social_whatsapp" placeholder="+91 1234567890"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            {{-- Footer Settings --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i data-lucide="layout" class="w-5 h-5 mr-2 text-orange-600"></i>
                    Footer Settings
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">About Text</label>
                        <textarea wire:model="settings.footer_about" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Copyright Text</label>
                        <input type="text" wire:model="settings.footer_copyright"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                <button wire:click="save"
                    class="w-full px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg mb-3 flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Save All Settings
                </button>

                <hr class="my-4 border-gray-100">

                <div class="space-y-2">
                    <h4 class="text-sm font-bold text-gray-900 uppercase tracking-widest">Maintenance</h4>
                    <button wire:click="runBackup" wire:loading.attr="disabled"
                        class="w-full px-4 py-3 bg-white border border-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition shadow-sm flex items-center justify-center">
                        <i wire:loading.remove data-lucide="database" class="w-5 h-5 mr-2 text-gray-400"></i>
                        <svg wire:loading class="animate-spin h-5 w-5 mr-3 text-blue-600" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span wire:loading.remove>Backup Database</span>
                        <span wire:loading>Backing up...</span>
                    </button>
                </div>
                <div class="text-xs text-gray-600 bg-gray-50 p-3 rounded-lg mt-4">
                    <p class="font-medium mb-1 flex items-center gap-1">
                        <i data-lucide="info" class="w-3 h-3"></i>
                        💡 Quick Tips:
                    </p>
                    <ul class="space-y-1 list-disc list-inside">
                        <li>Changes apply site-wide</li>
                        <li>Social links are optional</li>
                        <li>Footer updates instantly</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>