<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WasteType>
 */
class WasteTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Kertas',
            'Plastik',
            'Logam',
            'Kaca',
            'Tekstil',
            'Karet',
            'Elektronik',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name . '-' . fake()->unique()->numberBetween(10, 999)),
            'description' => fake()->sentence(12),
            'image_path' => null,
            'price_per_kg' => fake()->randomFloat(2, 1000, 20000),
            'is_active' => true,
        ];
    }
}
