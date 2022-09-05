<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class RealEstateDevelopmentFactory.
 *
 * @package BildVitta\SpProduto\Factories
 */
class RealEstateDevelopmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RealEstateDevelopment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        // Ribeirão Preto Lang e Long
        $lang = -21.177778;
        $long = -47.810000;

        $city = fake()->city;

        return [
            'uuid' => fake()->uuid(),
            'status' => fake()->randomKey(RealEstateDevelopment::STATUS_LIST),
            'address' => fake()->streetName,
            'city' => $city,
            'complement' => fake()->numberBetween(1, 300),
            'construction_address' => fake()->streetName,
            'construction_city' => $city,
            'construction_complement' => fake()->numberBetween(1, 300),
            'construction_neighborhood' => fake()->words(5, true),
            'construction_phone' => fake()->phoneNumber,
            'construction_postal_code' => fake()->postcode,
            'construction_state' => fake()->state,
            'construction_street_number' => fake()->numberBetween(1, 300),
            'description' => fake()->paragraph,
            'document' => fake()->cnpj(false),
            'latitude' => fake()->latitude($min = ($lang - (rand(0, 500) / 1000)), $max = ($lang + (rand(0, 500) / 1000))),
            'longitude' => fake()->longitude($min = ($long - (rand(0, 500) / 1000)), $max = ($long + (rand(0, 500) / 1000))),
            'legal_text' => fake()->paragraph,
            'name' => fake()->company . ' ' . fake()->companySuffix,
            'neighborhood' => fake()->words(5, true),
            'nickname' => fake()->company,
            'nire' => fake()->numerify('###########'),
            'nire_date' => fake()->date(),
            'postal_code' => fake()->postcode,
            'real_estate' => fake()->company . ' ' . fake()->companySuffix,
            'real_estate_logo' => 'https://placeimg.com/640/480/arch?' . fake()->uuid,
            'register_number' => fake()->numerify('###########'),
            'registration_number' => fake()->numerify('###########'),
            'registry_office' => fake()->words(5, true),
            'state' => fake()->state,
            'street_number' => fake()->numberBetween(1, 300),
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()->id,
            'external_code' => fake()->unique()->numberBetween(1, 300),
            'external_num_code' => fake()->numberBetween(50, 300),
            'external_company_code' => fake()->numberBetween(2, 300),
            'external_subsidiary_code' => fake()->numberBetween(90, 300),
        ];
    }
}
