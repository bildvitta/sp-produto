<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\AccessoryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class CategoryFactory.
 *
 * @package BildVitta\SpProduto\Factories
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccessoryCategory::class;

    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->words(5, true),
            'description' => fake()->text,
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()?->id,
        ];
    }
}
