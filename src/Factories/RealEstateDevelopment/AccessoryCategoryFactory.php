<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\AccessoryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AccessoryCategoryFactory.
 */
class AccessoryCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccessoryCategory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->userName(),
        ];
    }
}
