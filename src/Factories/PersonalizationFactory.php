<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\Personalization;
use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class EnvironmentFactory.
 */
class PersonalizationFactory extends Factory
{
    protected $model = Personalization::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(5, true),
            'value' => 1,
            'description' => $this->faker->text(),
            'real_estate_development_id' => RealEstateDevelopment::factory(),
            'is_active' => true,
        ];
    }

    public function afterNow()
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => now()->addDays(random_int(1, 10)),
            ];
        });
    }

    public function beforeNow()
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => now()->subDays(random_int(1, 10)),
            ];
        });
    }
}
}
