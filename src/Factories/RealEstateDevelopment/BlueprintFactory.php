<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Blueprint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class BlueprintFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class BlueprintFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blueprint::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->company,
            'description' => $this->faker->text(),
        ];
    }
}
