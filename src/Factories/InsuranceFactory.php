<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\Insurance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class InsuranceFactory.
 *
 * @package BildVitta\SpProduto\Factories
 */
class InsuranceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Insurance::class;

    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->words(5, true),
            'rate' => fake()->numberBetween(0, 100),
            'external_code' => fake()->numerify('#######'),
            'is_active' => fake()->boolean(),
        ];
    }
}
