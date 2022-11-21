<?php

namespace App\Http\Livewire;

use App\Constants\Statuses;
use App\Models\Blog;
use Livewire\Component;

class BlogComponent extends Component
{
    public function render()
    {
        return view(
            'livewire.blog-component',
            [
                'blogs' => Blog::where('status', Statuses::AVAILABLE)->paginate(10),
            ]
        );
    }
}
