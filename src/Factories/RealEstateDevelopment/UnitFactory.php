<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class UnitFactory.
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
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->words(3, true),
            'code' => $this->faker->unique()->numberBetween(100, 10000),
            'unit_type' => $this->faker->randomKey(Unit::UNIT_TYPE_LIST),
            'floor' => $this->faker->numberBetween(1, 20),
            'square_meters' => $this->faker->numberBetween(200, 400),
            'ideal_fraction' => $this->faker->numberBetween(1, 50),
            'factor' => $this->faker->numberBetween(1, 10000),
            'special_needs' => $this->faker->boolean(),
            'observations' => $this->faker->paragraphs(3, true),
            'ready_to_live_in' => $this->faker->date(),
            'notary_registration' => $this->faker->numberBetween(100000, 200000),
            'property_tax_identification' => $this->faker->numberBetween(100000, 200000),
            'has_empty_fields' => $this->faker->numberBetween(1, 10),
            'external_code' => $this->faker->numberBetween(1, 10000),
            'external_subsidiary_code' => $this->faker->unique()->numberBetween(1, 10000),
        ];
    }
}
