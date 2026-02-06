<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Login extends Component
{
    public $mobile_number = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $this->validate([
            'mobile_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('mobile_number', $this->mobile_number)->first();

        if ($user && Hash::check($this->password, $user->password)) {
            Auth::login($user, $this->remember);

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->to('/admin/test');
            }

            return redirect()->to('/rooms');
        }

        $this->addError('mobile_number', 'Invalid mobile number or password.');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
