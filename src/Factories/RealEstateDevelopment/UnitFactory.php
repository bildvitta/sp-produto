<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class UnitFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class UnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Unit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->words(3, true),
            'code' => fake()->unique()->numberBetween(100, 10000),
            'unit_type' => fake()->randomKey(Unit::UNIT_TYPE_LIST),
            'floor' => fake()->numberBetween(1, 20),
            'square_meters' => fake()->numberBetween(200, 400),
            'ideal_fraction' => fake()->numberBetween(1, 50),
            'fixed_price' => fake()->numberBetween(10000, 200000),
            'factor' => fake()->numberBetween(1, 10000),
            'special_needs' => fake()->boolean(),
            'observations' => fake()->paragraphs(3, true),
            'ready_to_live_in' => fake()->date(),
            'notary_registration' => fake()->numberBetween(100000, 200000),
            'property_tax_identification' => fake()->numberBetween(100000, 200000),
            'has_empty_fields' => fake()->numberBetween(1, 10),
            'external_code' => fake()->numberBetween(1, 10000),
            'external_subsidiary_code' => fake()->unique()->numberBetween(1, 10000),
        ];
    }
}
