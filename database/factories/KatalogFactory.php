<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Katalog>
 */
class KatalogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { // cover diambil dari images.unsplash.com
        $json = 'https://api.unsplash.com/photos/?client_id=e8RKNU4IbfF07bQFvdIsqkxqA-XsYyDy4g9FLftS6v0';
        $data = json_decode(file_get_contents($json), true);
        // random cover
        $cover = $data[array_rand($data)]['urls']['regular'];
        return [
            'judul' => $this->faker->sentence(),
            'penulis' => $this->faker->name(),
            'penerbit' => $this->faker->company(),
            'tahun' => $this->faker->year(),
            'jenis' => $this->faker->randomElement(['buku', 'jurnal', 'tugas akhir']),
            'stok' => $this->faker->numberBetween(1, 100),
            'cover' => $cover,
        ];
    }
}
