<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Accessory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AccessoryFactory.
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
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'accessory_id' => Accessory::inRandomOrder()->first(),
            'stock_quantity' => $this->faker->numberBetween(1, 50),
            'order' => $this->faker->randomNumber(1, 100),
            'start_at' => now(),
            'end_at' => now()->addDays($this->faker->numerify('##')),
        ];
    }
}
