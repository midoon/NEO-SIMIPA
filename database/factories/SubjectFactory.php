<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Matematika',
                'Bahasa Indonesia',
                'Bahasa Inggris',
                'Ilmu Pengetahuan Alam',
                'Ilmu Pengetahuan Sosial',
                'Pendidikan Pancasila dan Kewarganegaraan',
                'Seni Budaya',
                'Pendidikan Jasmani, Olahraga, dan Kesehatan'
            ]),
            'code' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
        ];
    }
}
