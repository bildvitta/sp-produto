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
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name,
            'allow_commercialization' => $this->faker->boolean(),
            'blueprint_definition_deadline' => $this->faker->date(),
            'commercialization_status' => $this->faker->randomKey(Parameter::COMMERCIALIZATION_STATUS_LIST),
            'construction_over_in' => $this->faker->date(),
            'construction_prevision_in' => $this->faker->date(),
            'construction_start_in' => $this->faker->date(),
            'financial_transfer_deadline' => $this->faker->date(),
            'financial_transfer_status' => $this->faker->randomKey(Parameter::FINANCIAL_TRANSFER_STATUS_LIST),
            'hand_over_keys_in' => $this->faker->date(),
            'in_financial_transfer' => $this->faker->boolean(),
            'launch_in' => $this->faker->dateTimeBetween('+1 year', '+2 years'),
            'pre_launch_in' => $this->faker->dateTimeBetween('now', '+2 years'),
            'ready_to_live_in' => $this->faker->dateTimeBetween('+2 years', '+3 years'),
            'square_meter_price' => $this->faker->numberBetween(1, 100),
            'steps' => $this->faker->randomKey(Parameter::STEPS_LIST),
            'verge' => $this->faker->randomKey(Parameter::VERGE_LIST),
        ];
    }
}
