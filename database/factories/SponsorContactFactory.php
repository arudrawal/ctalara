<?php

namespace Database\Factories;

use App\Models\SponsorContact;
use Illuminate\Database\Eloquent\Factories\Factory;

class SponsorContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SponsorContact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->phoneNumber(),
            'email' => $this->faker->freeEmail(),//email()
            'fax' => $this->faker->phoneNumber(),
        ];
    }
}
