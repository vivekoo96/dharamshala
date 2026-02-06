<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Faq extends Component
{
    public function render()
    {
        return view('livewire.public.faq');
    }
}
