<?php

namespace BildVitta\SpProduto\Factories;

use BildVitta\SpProduto\Models\RealEstateDevelopment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class RealEstateDevelopmentFactory.
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
     */
    public function definition(): array
    {
        // Ribeirão Preto Lang e Long
        $lang = -21.177778;
        $long = -47.810000;

        $city = $this->faker->city;

        return [
            'uuid' => $this->faker->uuid(),
            'status' => $this->faker->randomKey(RealEstateDevelopment::STATUS_LIST),
            'address' => $this->faker->streetName,
            'city' => $city,
            'complement' => $this->faker->numberBetween(1, 300),
            'construction_address' => $this->faker->streetName,
            'construction_city' => $city,
            'construction_complement' => $this->faker->numberBetween(1, 300),
            'construction_neighborhood' => $this->faker->words(5, true),
            'construction_phone' => $this->faker->phoneNumber,
            'construction_postal_code' => $this->faker->postcode,
            'construction_state' => $this->faker->state,
            'construction_street_number' => $this->faker->numberBetween(1, 300),
            'description' => $this->faker->paragraph,
            'document' => $this->faker->cnpj(false),
            'latitude' => $this->faker->latitude($min = ($lang - (rand(0, 500) / 1000)), $max = ($lang + (rand(0, 500) / 1000))),
            'longitude' => $this->faker->longitude($min = ($long - (rand(0, 500) / 1000)), $max = ($long + (rand(0, 500) / 1000))),
            'legal_text' => $this->faker->paragraph,
            'name' => $this->faker->company.' '.$this->faker->companySuffix,
            'neighborhood' => $this->faker->words(5, true),
            'nickname' => $this->faker->company,
            'nire' => $this->faker->numerify('###########'),
            'nire_date' => $this->faker->date(),
            'postal_code' => $this->faker->postcode,
            'real_estate' => $this->faker->company.' '.$this->faker->companySuffix,
            'real_estate_logo' => 'https://placeimg.com/640/480/arch?'.$this->faker->uuid,
            'register_number' => $this->faker->numerify('###########'),
            'registration_number' => $this->faker->numerify('###########'),
            'registry_office' => $this->faker->words(5, true),
            'state' => $this->faker->state,
            'street_number' => $this->faker->numberBetween(1, 300),
            'hub_company_id' => config('sp-produto.model_company')::inRandomOrder()->first()?->id,
            'external_code' => $this->faker->unique()->numberBetween(1, 300),
            'external_num_code' => $this->faker->numberBetween(50, 300),
            'external_company_code' => $this->faker->numberBetween(2, 300),
            'external_subsidiary_code' => $this->faker->numberBetween(90, 300),
        ];
    }
}
