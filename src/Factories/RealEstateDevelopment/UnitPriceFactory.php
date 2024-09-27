<?php

namespace Database\Factories\Entities\RealEstateDevelopment;

use Bildvitta\IssVendas\Models\Produto\Unit;
use BildVitta\SpProduto\Models\RealEstateDevelopment\UnitPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UnitPrice>
 */
class UnitPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UnitPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_id' => Unit::factory(),
            'period' => $this->faker->dateTimeThisYear()->format('Y-m-d'),
            'fixed_price' => $this->faker->randomFloat(2, 100000, 1000000),
            'table_price' => $this->faker->randomFloat(2, 100000, 1000000),
        ];
    }
}
