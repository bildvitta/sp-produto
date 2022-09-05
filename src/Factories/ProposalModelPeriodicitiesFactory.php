<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\ProposalModelPeriodicities;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class ProposalModelPeriodicitiesFactory.
 *
 * @package BildVitta\SpProduto\Factories
 */
class ProposalModelPeriodicitiesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProposalModelPeriodicities::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $update_installments_quantity = fake()->boolean;
        $pin_value = fake()->boolean;

        return [
            'uuid' => fake()->uuid(),
            'update_installments_quantity' => $update_installments_quantity,
            'installments' => $update_installments_quantity === false ? 0 : fake()->numberBetween(1, 360),
            'add_on_type' => fake()->randomKey(ProposalModelPeriodicities::ADD_ON_TYPE_LIST),
            'periodicity_quantity' => fake()->numberBetween(1, 360),
            'pin_value' => $pin_value,
            'add_on_value' => $pin_value ? fake()->randomFloat(2, 10, 999999) : null,
        ];
    }
}
