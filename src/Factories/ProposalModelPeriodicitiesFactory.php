<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\ProposalModelPeriodicities;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class ProposalModelPeriodicitiesFactory.
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
     */
    public function definition(): array
    {
        $update_installments_quantity = $this->faker->boolean;
        $pin_value = $this->faker->boolean;

        return [
            'update_installments_quantity' => $update_installments_quantity,
            'installments' => $update_installments_quantity === false ? 0 : $this->faker->numberBetween(1, 360),
            'periodicity' => $this->faker->randomKey(ProposalModelPeriodicities::PERIODICITY_LIST),
            'pin_value' => $pin_value,
            'add_on_type' => $pin_value ? 'fixed_value' : null,
            'add_on_value' => $pin_value ? $this->faker->randomFloat(2, 10, 999999) : null,
            'editable' => $this->faker->boolean,
            'due_date_type' => $this->faker->randomKey(ProposalModelPeriodicities::DUE_DATE_TYPE_LIST),
            'due_dates' => $this->faker->numberBetween(30, 180),
        ];
    }
}
