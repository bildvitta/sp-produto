<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class StageFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class StageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $latest = Stage::latest()->first();

        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->words(5, true),
            'registered_at' => fake()->date(),
            'foundation' => fake()->numberBetween($latest ? $latest->foundation : 1, 100),
            'masonry' => fake()->numberBetween($latest ? $latest->masonry : 1, 100),
            'structure' => fake()->numberBetween($latest ? $latest->structure : 1, 100),
            'finishing' => fake()->numberBetween($latest ? $latest->finishing : 1, 100),
        ];
    }
}
