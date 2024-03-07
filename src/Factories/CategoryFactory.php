<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\AccessoryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class CategoryFactory.
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
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->words(5, true),
            'description' => $this->faker->text,
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()?->id,
        ];
    }
}
