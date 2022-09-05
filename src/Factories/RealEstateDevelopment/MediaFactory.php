<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class MediaFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->word,
            'description' => fake()->paragraph,
            'preview' => 'https://placeimg.com/640/480/any?' . fake()->uuid,
            'media_type' => fake()->randomKey(Media::MEDIA_TYPE_LIST),
            'url' => fake()->imageUrl(),
            'format' => fake()->fileExtension,
            'active' => fake()->boolean,
        ];
    }
}
