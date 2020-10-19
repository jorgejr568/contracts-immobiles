<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contract::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'receiver_email' => $this->faker->email,
            'receiver_name' => $this->faker->name,
            'document_type' => Contract::DOCUMENT_TYPE_PERSON,
            'document_number' => $this->randomDocument(
                Contract::DOCUMENT_TYPE_PERSON_LENGTH,
            ),
        ];
    }

    public function document_entity()
    {
        return $this->state(function () {
            return [
                'document_type' => Contract::DOCUMENT_TYPE_ENTITY,
                'document_number' => $this->randomDocument(
                    Contract::DOCUMENT_TYPE_ENTITY_LENGTH,
                ),
            ];
        });
    }

    public function with_immobile()
    {
        return $this->state(function () {
            $immobile = ImmobileFactory::new()->create();
            return [
                'immobile_id' => $immobile->id,
            ];
        });
    }

    private function randomDocument($length)
    {
        return str_pad(random_int(0, str_repeat(9, $length)), $length);
    }
}
