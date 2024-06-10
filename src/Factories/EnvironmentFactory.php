<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\Environment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class EnvironmentFactory.
 */
class EnvironmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Environment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
        ];
    }
}
