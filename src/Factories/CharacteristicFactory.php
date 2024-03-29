<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\Characteristic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class CharacteristicFactory.
 */
class CharacteristicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Characteristic::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->words(5, true),
            'description' => $this->faker->text,
            'icon' => 'https://placeimg.com/640/480/any?'.$this->faker->uuid,
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()?->id,
        ];
    }
}
