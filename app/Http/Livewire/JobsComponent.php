<?php

namespace App\Http\Livewire;

use App\Constants\Statuses;
use App\Models\Job;
use Livewire\Component;

class JobsComponent extends Component
{
    public function render()
    {
        return view('livewire.jobs-component',
    [
        'jobs' => Job::where('status', Statuses::AVAILABLE)->paginate(10),
    ]);
    }
}
