<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\InsuranceCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class InsuranceCompanyFactory.
 *
 * @package BildVitta\SpProduto\Factories
 */
class InsuranceCompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InsuranceCompany::class;

    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->words(5, true),
            'company_name' => fake()->words(5, true),
            'document' => fake()->cnpj(false),
            'susep' => fake()->numerify('#####'),
            'is_active' => fake()->boolean(),
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()?->id,
        ];
    }
}
