<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakultas = [
            [
                'id' => 1,
                'nama' => 'Ekonomi dan Bisnis',
                'singkatan' => 'FE',
            ],
            [
                'id' => 2,
                'nama' => 'Sains dan Teknologi',
                'singkatan' => 'FST',
            ],
            [
                'id' => 3,
                'nama' => 'Pertanian, Kehutanan, dan Kelautan',
                'singkatan' => 'FPKK',
            ]
        ];
        Fakultas::insert($fakultas);
    }
}
