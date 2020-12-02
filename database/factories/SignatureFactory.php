<?php

namespace Database\Factories;

use App\Enums\SignatureStatus;
use App\Enums\SignatureType;
use App\Models\Signature;
use Illuminate\Database\Eloquent\Factories\Factory;

class SignatureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Signature::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type' => SignatureType::PIMPINAN(),
            'occupation_name' => 'Kepala Dinas Kominfo',
            'content' => $this->faker->text,
            'status' => SignatureStatus::PUBLISHED(),
        ];
    }
}
