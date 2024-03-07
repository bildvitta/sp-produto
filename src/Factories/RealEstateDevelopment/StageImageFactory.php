<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\StageImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class StageImageFactory.
 */
class StageImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StageImage::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->words(5, true),
            'image' => 'https://placeimg.com/640/480/any?'.$this->faker->uuid,
            'format' => $this->faker->mimeType(),
        ];
    }
}
