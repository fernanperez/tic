<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Internship>
 */
class InternshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(1, true),
            'description' => $this->faker->paragraph(4, true),
            'company_name' => $this->faker->company(),
            'img_path' => $this->faker->imageUrl(),
            'job_title' => $this->faker->jobTitle(),
            'tag' => $this->faker->word()
        ];
    }
}
