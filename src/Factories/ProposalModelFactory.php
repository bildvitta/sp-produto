<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\ProposalModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class ProposalModelFactory.
 *
 * @package BildVitta\SpProduto\Factories
 */
class ProposalModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProposalModel::class;

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
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()->id
        ];
    }
}
