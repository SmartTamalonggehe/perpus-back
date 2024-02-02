<?php

namespace Database\Factories;

use App\Models\Prodi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // random prodi
        $prodi = Prodi::inRandomOrder()->first();
        return [
            'prodi_id' => $prodi->id,
            'nama' => $this->faker->name,
            'NPM' => $this->faker->ean8,
            'jenkel' => $this->faker->randomElement(['Laki-Laki', 'Perempuan']),
            'alamat' => $this->faker->address,
            'no_hp' => $this->faker->phoneNumber,
            'foto' => $this->faker->imageUrl(),
        ];
    }
}
