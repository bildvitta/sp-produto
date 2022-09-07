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
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->words(5, true),
            'description' => $this->faker->text(),
            'type_increase' => $this->faker->randomKey(TypologyAttribute::ADDITION_TYPE),
            'value_increase' => $this->faker->randomFloat(2, 0, 9999)
        ];
    }
}
