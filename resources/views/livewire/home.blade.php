<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Product Testing Results</h1>
                <p class="mt-2 text-gray-600">
                    Browse and compare test results from Project Farm videos. Click a category to see detailed product comparisons.
                </p>
            </div>

            @if($categories->isEmpty())
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Categories Yet</h3>
                        <p class="text-gray-600">We're still gathering data. Check back soon for product comparisons!</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categories as $category)
                        <a href="/category/{{ $category->slug }}" class="block group">
                            <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-200 p-6 h-full">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 mb-2">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $category->description }}
                                </p>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">
                                        {{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}
                                    </span>
                                    <span class="text-indigo-600 group-hover:translate-x-1 transition-transform duration-200 inline-block">
                                        View →
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
