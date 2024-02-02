<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Katalog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // random anggota
        $anggota = Anggota::inRandomOrder()->first();
        // random katalog
        $katalog = Katalog::inRandomOrder()->first();
        return [
            'anggota_id' => $anggota->id,
            'katalog_id' => $katalog->id,
            'status' => $this->faker->randomElement(['peminjaman', 'pengembalian']),
            'tgl_pinjam' => $this->faker->date,
        ];
    }
}
