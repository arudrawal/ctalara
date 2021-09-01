<?php

namespace Database\Factories;

use App\Models\StudySite;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudySiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudySite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return ['code'=> $this->faker->company(), 
                'name'=> '', 
                'department'=> $this->faker->cityPrefix(), 
                'address' => $this->faker->streetAddress(), 
                'city' => $this->faker->city(), 
                'state' => $this->faker->state(),
                'country' => $this->faker->country(),
                'contact' => $this->faker->name(), 
                'phone'=>$this->faker->phone(), 
                'email'=>$this->faker->email(),
        ];
    }
}
