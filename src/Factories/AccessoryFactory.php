<?php

namespace BildVitta\SpProduto\Factories;

use App\Models\Settings\Category;
use BildVitta\SpProduto\Models\Accessory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AccessoryFactory.
 *
 * @package BildVitta\SpProduto\Factories
 */
class AccessoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Accessory::class;

    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->words(5, true),
            'description' => fake()->text,
            'category_id' => Category::inRandomOrder()->first(),
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()->id,
        ];
    }
}
