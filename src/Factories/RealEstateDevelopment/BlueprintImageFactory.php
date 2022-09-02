<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\BlueprintImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class BlueprintImageFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class BlueprintImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlueprintImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->words(5, true),
            'image' => 'https://placeimg.com/640/480/any?' . fake()->uuid,
            'format' => fake()->mimeType(),
        ];
    }
}
