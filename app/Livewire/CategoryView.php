<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
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
        $attributes = $this->category->attributes;
        
        $query = Product::where('category_id', $this->category->id)
            ->with('productAttributes.attribute');
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('model', 'like', '%' . $this->search . '%');
            });
        }
        
        $products = $query->get();
        
        if ($this->sortBy) {
            $products = $products->sortBy(function($product) {
                $value = $product->getAttributeValue($this->sortBy);
                
                $attribute = Attribute::find($this->sortBy);
                if ($attribute && $attribute->type === 'numeric' && is_numeric($value)) {
                    return (float) $value;
                }
                return $value;
            }, SORT_REGULAR, $this->sortDirection === 'desc');
        }
        
        return view('livewire.category-view', [
            'attributes' => $attributes,
            'products' => $products,
        ])->layout('layouts.app');
    }
}
