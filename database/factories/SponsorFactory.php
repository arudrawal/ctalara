<?php

namespace Database\Factories;

use App\Models\Sponsor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SponsorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sponsor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //'phone1' => $this->faker->phoneNumber(),
        return [
            'name' => $this->faker->company(),//$this->faker->companySuffix('Pharma'),
            'code' => $this->faker->regexify('[A-Z]{4}-[0-4]{4}'),
            'address' => $this->faker->address(),
        ];
    }
}
