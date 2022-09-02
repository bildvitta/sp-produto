<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Characteristic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class CharacteristicFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class CharacteristicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Characteristic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'order' => rand(1, 20),
            'differential' => fake()->boolean,
            'description' => fake()->text,
        ];
    }
}
