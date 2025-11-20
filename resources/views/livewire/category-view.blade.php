<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <a href="/" class="text-indigo-600 hover:text-indigo-800 mb-2 inline-block">← Back to Categories</a>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                        <p class="mt-2 text-gray-600">{{ $category->description }}</p>
                    </div>
                </div>

                @if($category->video_urls && count($category->video_urls) > 0)
                    <div class="mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Source Videos:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($category->video_urls as $url)
                                <a href="{{ $url }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm hover:bg-red-200">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                    Watch on YouTube
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="mb-6">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search products..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                >
            </div>

            @if($products->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-600">No products found in this category.</p>
                    <a href="/admin" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
                        Add Products in Admin
                    </a>
                </div>
            @else
                <div class="bg-white rounded-lg shadow overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50">
                                    Product
                                </th>
                                @foreach($attributes as $attribute)
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
                                        wire:click="sortByAttribute({{ $attribute->id }})">
                                        <div class="flex items-center space-x-1">
                                            <span>{{ $attribute->name }}</span>
                                            @if($attribute->unit)
                                                <span class="text-gray-400">({{ $attribute->unit }})</span>
                                            @endif
                                            @if($sortBy == $attribute->id)
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    @if($sortDirection === 'asc')
                                                        <path d="M5 10l5-5 5 5H5z"/>
                                                    @else
                                                        <path d="M15 10l-5 5-5-5h10z"/>
                                                    @endif
                                                </svg>
                                            @endif
                                            @if($attribute->is_primary_metric)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    ★
                                                </span>
                                            @endif
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white">
                                        <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                        @if($product->brand && $product->brand !== $product->name)
                                            <div class="text-sm text-gray-500">{{ $product->brand }}</div>
                                        @endif
                                        @if($product->model)
                                            <div class="text-xs text-gray-400">Model: {{ $product->model }}</div>
                                        @endif
                                    </td>
                                    @foreach($attributes as $attribute)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $product->getAttributeValue($attribute->id) ?? '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-sm text-gray-600">
                    Showing {{ $products->count() }} {{ Str::plural('product', $products->count()) }}
                </div>
            @endif
        </div>
    </div>
</div>
