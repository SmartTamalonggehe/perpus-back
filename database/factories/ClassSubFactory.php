<?php

namespace Database\Factories;

use App\Models\ClassUmum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassSub>
 */
class ClassSubFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $class_umum_id = ClassUmum::inRandomOrder()->first()->id;
        return [
            'class_umum_id' => $class_umum_id,
            'nm_sub' => $this->faker->sentence(),
        ];
    }
}
