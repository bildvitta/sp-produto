<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class DocumentFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Document::class;

    /**
     * Define the model's default state.
     *
     * @see \App\Providers\AppServiceProvider::register() For imageUrl document
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->words(3, true),
            'description' => fake()->text(300),
            'format' => fake()->fileExtension,
            'url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf?' . fake()->uuid,
            'preview' => fake()->optional(0.8)->passthrough('https://placeimg.com/640/480/tech?' . fake()->uuid),
            'active' => fake()->boolean,
        ];
    }
}
