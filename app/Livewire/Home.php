<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.home');
    }
}
