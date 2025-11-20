<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $categories = Category::withCount('products')->get();
        
        return view('livewire.home', [
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}
