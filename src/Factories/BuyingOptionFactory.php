<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\BuyingOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class BuyingOptionFactory.
 *
 * @package BildVitta\SpProduto\Factories
 */
class BuyingOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BuyingOption::class;

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
            'income_commitment' => fake()->numberBetween(1, 80),
            'when_flow_sent' => fake()->randomKey(BuyingOption::WHEN_FLOW_SENT_LIST),
            'when_flow_validated' => fake()->randomKey(BuyingOption::WHEN_FLOW_VALIDATED_LIST),
            'when_make_sale' => fake()->randomKey(BuyingOption::WHEN_MAKE_SALE_LIST),
            'when_reserve_unit' => fake()->randomKey(BuyingOption::WHEN_RESERVE_UNIT_LIST),
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()?->id,
        ];
    }
}
