<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class MediaFactory.
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
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'preview' => 'https://placeimg.com/640/480/any?'.$this->faker->uuid,
            'media_type' => $this->faker->randomKey(Media::MEDIA_TYPE_LIST),
            'url' => $this->faker->imageUrl(),
            'format' => $this->faker->fileExtension,
            'active' => $this->faker->boolean,
        ];
    }
}
