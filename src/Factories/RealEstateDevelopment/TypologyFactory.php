<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Typology;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class TypologyFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class TypologyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Typology::class;

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
        ];
    }
}
