<?php

namespace App\Livewire;

use App\Models\Page;
use Livewire\Component;

class PageView extends Component
{
    public Page $page;

    public function mount(string $slug)
    {
        $this->page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.page-view');
    }
}
