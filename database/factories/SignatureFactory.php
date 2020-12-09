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
        $type = Arr::random($typesArray);

        $occupationName = null;

        if ($type === SignatureType::PIMPINAN()->value) {
            $occupationName = 'Pimpinan Provinsi Jawa Barat';
        }

        if ($type === SignatureType::PIMPINAN_OPD()->value) {
            $occupationName = 'Kepala Dinas Provinsi Jawa Barat';
        }

        if ($type === SignatureType::INSPEKTORAT()->value) {
            $occupationName = 'Inspektorat Provinsi Jawa Barat';
        }

        if ($type === SignatureType::WALIKOTA()->value) {
            $occupationName = 'Walikota Kota Jawa Barat';
        }

        if ($type === SignatureType::PUBLIC()->value) {
            $occupationName = 'Masyarakat Umum';
        }

        return [
            'first_name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone_number' => '085729402679',
            'type' => $type,
            'occupation_name' => $occupationName,
            // 'workplace_name' => 'Provinsi Jawa Barat',
            'content' => $this->faker->text,
            'signature_path' => 'ttd-example.png',
            'status' => SignatureStatus::PUBLISHED(),
        ];
    }
}
