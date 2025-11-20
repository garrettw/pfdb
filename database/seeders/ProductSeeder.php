<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $penetratingOils = \App\Models\Category::where('slug', 'penetrating-oils')->first();
        $batteries = \App\Models\Category::where('slug', 'aa-batteries')->first();
        $chainsaws = \App\Models\Category::where('slug', 'chainsaws')->first();

        if ($penetratingOils) {
            $products = [
                ['name' => 'PB Blaster', 'brand' => 'PB Blaster', 'attributes' => ['58', '42', '5.99', '7']],
                ['name' => 'WD-40', 'brand' => 'WD-40', 'attributes' => ['35', '28', '4.99', '5']],
                ['name' => 'Liquid Wrench', 'brand' => 'Liquid Wrench', 'attributes' => ['51', '38', '5.49', '6']],
                ['name' => 'Royal Purple MaxTred', 'brand' => 'Royal Purple', 'attributes' => ['62', '48', '9.99', '4']],
                ['name' => 'Kroil', 'brand' => 'Kano', 'attributes' => ['67', '52', '14.99', '3']],
            ];

            $attributes = $penetratingOils->attributes;
            foreach ($products as $productData) {
                $product = \App\Models\Product::create([
                    'category_id' => $penetratingOils->id,
                    'name' => $productData['name'],
                    'brand' => $productData['brand'],
                ]);

                foreach ($attributes as $index => $attribute) {
                    \App\Models\ProductAttribute::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute->id,
                        'value' => $productData['attributes'][$index] ?? '',
                    ]);
                }
            }
        }

        if ($batteries) {
            $products = [
                ['name' => 'Duracell', 'brand' => 'Duracell', 'attributes' => ['8.2', '1.48', '1.25', '0.15']],
                ['name' => 'Energizer', 'brand' => 'Energizer', 'attributes' => ['7.9', '1.47', '1.20', '0.15']],
                ['name' => 'Amazon Basics', 'brand' => 'Amazon', 'attributes' => ['6.8', '1.45', '0.35', '0.05']],
                ['name' => 'Rayovac', 'brand' => 'Rayovac', 'attributes' => ['7.1', '1.46', '0.75', '0.11']],
                ['name' => 'Kirkland', 'brand' => 'Kirkland', 'attributes' => ['7.5', '1.47', '0.40', '0.05']],
            ];

            $attributes = $batteries->attributes;
            foreach ($products as $productData) {
                $product = \App\Models\Product::create([
                    'category_id' => $batteries->id,
                    'name' => $productData['name'],
                    'brand' => $productData['brand'],
                ]);

                foreach ($attributes as $index => $attribute) {
                    \App\Models\ProductAttribute::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute->id,
                        'value' => $productData['attributes'][$index] ?? '',
                    ]);
                }
            }
        }

        if ($chainsaws) {
            $products = [
                ['name' => 'Stihl MS 271', 'brand' => 'Stihl', 'model' => 'MS 271', 'attributes' => ['8.5', '9000', '12.3', '449', '18']],
                ['name' => 'Husqvarna 460 Rancher', 'brand' => 'Husqvarna', 'model' => '460 Rancher', 'attributes' => ['7.8', '9500', '13.2', '549', '20']],
                ['name' => 'Echo CS-590', 'brand' => 'Echo', 'model' => 'CS-590', 'attributes' => ['9.2', '8500', '13.8', '399', '20']],
            ];

            $attributes = $chainsaws->attributes;
            foreach ($products as $productData) {
                $product = \App\Models\Product::create([
                    'category_id' => $chainsaws->id,
                    'name' => $productData['name'],
                    'brand' => $productData['brand'],
                    'model' => $productData['model'] ?? null,
                ]);

                foreach ($attributes as $index => $attribute) {
                    \App\Models\ProductAttribute::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute->id,
                        'value' => $productData['attributes'][$index] ?? '',
                    ]);
                }
            }
        }
    }
}
