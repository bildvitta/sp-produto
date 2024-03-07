<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class StageFactory.
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
     */
    public function definition(): array
    {
        $latest = Stage::latest()->first();

        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->words(5, true),
            'registered_at' => $this->faker->date(),
            'foundation' => $this->faker->numberBetween($latest ? $latest->foundation : 1, 100),
            'masonry' => $this->faker->numberBetween($latest ? $latest->masonry : 1, 100),
            'structure' => $this->faker->numberBetween($latest ? $latest->structure : 1, 100),
            'finishing' => $this->faker->numberBetween($latest ? $latest->finishing : 1, 100),
        ];
    }
}
