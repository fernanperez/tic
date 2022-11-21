<?php

namespace App\Http\Livewire;

use App\Constants\Statuses;
use App\Models\Internship;
use Livewire\Component;

class InternshipsComponent extends Component
{
    public function render()
    {
        return view('livewire.internships-component',
    [
        'internships' => Internship::where('status', Statuses::AVAILABLE)->paginate(15),
    ]);
    }
}
