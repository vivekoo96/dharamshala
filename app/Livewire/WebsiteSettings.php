<?php

namespace App\Livewire;

use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class WebsiteSettings extends Component
{
    public $settings = [];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $allSettings = Setting::all();

        foreach ($allSettings as $setting) {
            $this->settings[$setting->key] = $setting->value;
        }

        // Set default values if not exists
        $this->ensureDefaults();
    }

    private function ensureDefaults()
    {
        $defaults = [
            // General
            'site_name' => 'Dharamshala Connect',
            'site_tagline' => 'Shree Ram Trust',
            'site_description' => 'Experience comfort, peace, and serenity in our well-maintained rooms.',

            // Contact
            'contact_phone' => '+91 1234567890',
            'contact_email' => 'info@dharamshalaconnect.com',
            'contact_address' => 'Shree Ram Trust, City, State - 123456',

            // Social Media
            'social_facebook' => '',
            'social_twitter' => '',
            'social_instagram' => '',
            'social_whatsapp' => '',

            // Footer
            'footer_about' => 'Shree Ram Trust provides comfortable and affordable accommodation for pilgrims and travelers.',
            'footer_copyright' => '© 2026 Dharamshala Connect. All rights reserved.',
        ];

        foreach ($defaults as $key => $value) {
            if (!isset($this->settings[$key])) {
                $this->settings[$key] = $value;
            }
        }
    }

    public function save()
    {
        foreach ($this->settings as $key => $value) {
            $group = $this->getGroup($key);
            $type = $this->getType($key);
            $label = $this->getLabel($key);

            Setting::set($key, $value, $group, $type, $label);
        }

        session()->flash('message', 'Settings saved successfully!');
    }

    public function runBackup()
    {
        try {
            Artisan::call('backup:run', ['--only-db' => true]);
            session()->flash('message', 'Database backup started successfully! Check storage/app for the backup file.');
        } catch (\Exception $e) {
            session()->flash('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    private function getGroup($key)
    {
        if (str_starts_with($key, 'site_'))
            return 'general';
        if (str_starts_with($key, 'contact_'))
            return 'contact';
        if (str_starts_with($key, 'social_'))
            return 'social';
        if (str_starts_with($key, 'footer_'))
            return 'footer';
        return 'general';
    }

    private function getType($key)
    {
        if (str_contains($key, 'email'))
            return 'email';
        if (str_contains($key, 'phone'))
            return 'phone';
        if (str_contains($key, 'url') || str_starts_with($key, 'social_'))
            return 'url';
        if (str_contains($key, 'description') || str_contains($key, 'about') || str_contains($key, 'address'))
            return 'textarea';
        return 'text';
    }

    private function getLabel($key)
    {
        return ucwords(str_replace('_', ' ', $key));
    }

    public function render()
    {
        return view('livewire.website-settings');
    }
}
