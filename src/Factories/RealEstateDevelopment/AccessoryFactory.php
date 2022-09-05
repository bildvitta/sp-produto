<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Accessory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AccessoryFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class AccessoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Accessory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'accessory_id' => Accessory::inRandomOrder()->first(),
            'stock_quantity' => fake()->numberBetween(1, 50),
            'order' => fake()->randomNumber(1, 100),
            'start_at' => now(),
            'end_at' => now()->addDays(fake()->numerify('##')),
        ];
    }
}
