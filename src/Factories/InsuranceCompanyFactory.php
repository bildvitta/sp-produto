<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\InsuranceCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class InsuranceCompanyFactory.
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
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->words(5, true),
            'company_name' => $this->faker->words(5, true),
            'document' => $this->faker->cnpj(false),
            'susep' => $this->faker->numerify('#####'),
            'is_active' => $this->faker->boolean(),
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()?->id,
        ];
    }
}
