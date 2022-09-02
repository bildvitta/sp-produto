<?php

namespace BildVitta\SpProduto\Factories\RealEstateDevelopment;

use BildVitta\SpProduto\Models\RealEstateDevelopment\Parameter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class ParameterFactory.
 *
 * @package BildVitta\SpProduto\Factories\RealEstateDevelopment
 */
class ParameterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Parameter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->name,
            'allow_commercialization' => fake()->boolean(),
            'blueprint_definition_deadline' => fake()->date(),
            'commercialization_status' => fake()->randomKey(Parameter::COMMERCIALIZATION_STATUS_LIST),
            'construction_over_in' => fake()->date(),
            'construction_prevision_in' => fake()->date(),
            'construction_start_in' => fake()->date(),
            'financial_transfer_deadline' => fake()->date(),
            'financial_transfer_status' => fake()->randomKey(Parameter::FINANCIAL_TRANSFER_STATUS_LIST),
            'hand_over_keys_in' => fake()->date(),
            'in_financial_transfer' => fake()->boolean(),
            'launch_in' => fake()->dateTimeBetween('+1 year', '+2 years'),
            'pre_launch_in' => fake()->dateTimeBetween('now', '+2 years'),
            'ready_to_live_in' => fake()->dateTimeBetween('+2 years', '+3 years'),
            'square_meter_price' => fake()->numberBetween(1, 100),
            'steps' => fake()->randomKey(Parameter::STEPS_LIST),
            'verge' => fake()->randomKey(Parameter::VERGE_LIST),
        ];
    }
}
