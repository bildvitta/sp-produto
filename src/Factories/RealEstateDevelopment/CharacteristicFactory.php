<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Characteristic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class CharacteristicFactory.
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
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'order' => rand(1, 20),
            'differential' => $this->faker->boolean,
            'description' => $this->faker->text,
        ];
    }
}
