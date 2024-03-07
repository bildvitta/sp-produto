<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\Insurance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class InsuranceFactory.
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
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->words(5, true),
            'rate' => $this->faker->numberBetween(0, 100),
            'external_code' => $this->faker->numerify('#######'),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
