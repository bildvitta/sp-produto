<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\AccessoryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AccessoryCategoryFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
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
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->userName()
        ];
    }
}
