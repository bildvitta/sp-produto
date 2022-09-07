<?php

namespace BildVitta\SpProduto\Factories;

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
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->words(5, true),
            'description' => $this->faker->text,
            'category_id' => 1,
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()?->id,
        ];
    }
}
