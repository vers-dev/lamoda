<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Reserve;
use App\Models\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reserve>
 */
class ReserveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::factory()->create();
        return [
            'storage_id' => Storage::where('is_active', true)->inRandomOrder()->first()->id,
            'product_id' => $product->id,
            'count' => round($product->count / 3, PHP_ROUND_HALF_DOWN),
        ];
    }
}
