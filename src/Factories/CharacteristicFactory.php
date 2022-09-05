<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\Characteristic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class CharacteristicFactory.
 *
 * @package BildVitta\SpProduto\Factories
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
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->words(5, true),
            'description' => fake()->text,
            'icon' => 'https://placeimg.com/640/480/any?' . fake()->uuid,
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()?->id,
        ];
    }
}
