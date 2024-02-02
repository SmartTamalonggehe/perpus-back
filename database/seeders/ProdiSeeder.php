<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodis = [
            [
                'id' => 1,
                'fakultas_id' => 1,
                'nama' => 'Manajemen',
                'singkatan' => 'ME',
            ],
            [
                'id' => 2,
                'fakultas_id' => 1,
                'nama' => 'Akuntansi',
                'singkatan' => 'AK',
            ],
            [
                'id' => 3,
                'fakultas_id' => 1,
                'nama' => 'Ekonomi Pembangunan',
                'singkatan' => 'EKBANG',
            ],
            [
                'id' => 4,
                'fakultas_id' => 2,
                'nama' => 'Sistem Informasi',
                'singkatan' => 'SI',
            ],
            [
                'id' => 5,
                'fakultas_id' => 2,
                'nama' => 'Biologi',
                'singkatan' => 'BI',
            ],
            [
                'id' => 6,
                'fakultas_id' => 2,
                'nama' => 'Teknik Geologi',
                'singkatan' => 'TG',
            ],
            [
                'id' => 7,
                'fakultas_id' => 3,
                'nama' => 'Agribisnis',
                'singkatan' => 'AB',
            ],
            [
                'id' => 8,
                'fakultas_id' => 3,
                'nama' => 'Argoteknologi',
                'singkatan' => 'ARG',
            ],
            [
                'id' => 9,
                'fakultas_id' => 3,
                'nama' => 'Kehutanan',
                'singkatan' => 'KEH',
            ],
            [
                'id' => 10,
                'fakultas_id' => 3,
                'nama' => 'Manajemen Sumber Daya Perairan',
                'singkatan' => 'MSDP',
            ]
        ];

        Prodi::insert($prodis);
    }
}
