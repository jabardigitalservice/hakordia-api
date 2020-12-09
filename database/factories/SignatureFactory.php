<?php

namespace Database\Factories;

use App\Enums\SignatureStatus;
use App\Enums\SignatureType;
use App\Models\Signature;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
        $typesArray = SignatureType::toArray();

        return [
            'first_name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone_number' => '085729402679',
            'type' => Arr::random($typesArray),
            'occupation_name' => 'Kepala Dinas',
            'workplace_name' => 'Provinsi Jawa Barat',
            'content' => $this->faker->text,
            'signature_path' => 'ttd-example.png',
            'status' => SignatureStatus::PUBLISHED(),
        ];
    }
}
