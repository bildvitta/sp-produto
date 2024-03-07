<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class DocumentFactory.
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
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->text(300),
            'format' => $this->faker->fileExtension,
            'url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf?'.$this->faker->uuid,
            'preview' => $this->faker->optional(0.8)->passthrough('https://placeimg.com/640/480/tech?'.$this->faker->uuid),
            'active' => $this->faker->boolean,
        ];
    }
}
