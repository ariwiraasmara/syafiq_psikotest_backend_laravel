<?php
// Copyright @
// Syafiq
// Syahri Ramadhan Wiraasmara
namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Home extends Component {

    #[Layout('layouts.app')]
    public function render() {
        return view('livewire.home');
    }

}