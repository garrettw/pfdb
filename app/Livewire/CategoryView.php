<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Url;

class CategoryView extends Component
{
    public Category $category;

    #[Url]
    public $sortBy = '';

    #[Url]
    public $sortDirection = 'asc';

    #[Url]
    public $search = '';

    public function mount($slug)
    {
        $this->category = Category::where('slug', $slug)->firstOrFail();
    }

    public function sortByAttribute($attributeId)
    {
        if ($this->sortBy == $attributeId) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $attributeId;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $attributes = collect($this->category->attributes);

        $query = Product::where('category_id', $this->category->id)
            ->with('productAttributes.attribute', 'retailerLinks.retailer');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('model', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->sortBy) {
            $attribute = $attributes->firstWhere('id', $this->sortBy);

            if ($attribute) {
                $query->leftJoin('product_attributes', function($join) {
                    $join->on('products.id', '=', 'product_attributes.product_id')
                         ->where('product_attributes.attribute_id', $this->sortBy);
                })
                ->select('products.*');

                if ($attribute->type === 'numeric') {
                    $query->orderByRaw('CAST(product_attributes.value AS REAL) ' . ($this->sortDirection === 'desc' ? 'DESC' : 'ASC'));
                } else {
                    $query->orderBy('product_attributes.value', $this->sortDirection);
                }
            }
        }

        $products = $query->get();

        return view('livewire.category-view', [
            'attributes' => $attributes,
            'products' => $products,
        ])->layout('layouts.app');
    }
}
