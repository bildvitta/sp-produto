<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\TypologyAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class TypologyAttributeFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class TypologyAttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TypologyAttribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->words(5, true),
            'description' => fake()->text(),
            'type_increase' => fake()->randomKey(TypologyAttribute::ADDITION_TYPE),
            'value_increase' => fake()->randomFloat(2, 0, 9999)
        ];
    }
}
