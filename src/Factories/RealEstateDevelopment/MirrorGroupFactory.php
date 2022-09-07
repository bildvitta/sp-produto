<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\MirrorGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class MirrorGroupFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class MirrorGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MirrorGroup::class;

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
