<?php

namespace Database\Factories;

use App\Models\Immobile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImmobileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Immobile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'email' => $this->faker->companyEmail,
            'state' => $this->faker->state,
            'city' => $this->faker->city,
            'neighborhood' => 'Springfield',
            'street' => $this->faker->streetName,
            'number' => $this->faker->numberBetween(1, 100),
            'complement' => $this->faker->text(30),
        ];
    }
}
