<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Mirror;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class MirrorsFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class MirrorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mirror::class;

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
            'mirror_type' => $this->faker->randomKey(Mirror::MIRROR_TYPES),
        ];
    }
}
