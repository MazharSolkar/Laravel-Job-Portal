<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Predefined set of keywords
        $keywordList = ['PHP', 'Laravel', 'Backend Developer', 'Full-stack', 'JavaScript', 'API', 'Agile'];

        return [
            'title'=> fake()->name,
            'job_type_id' => rand(1,5),
            'category_id' => rand(1,4),
            'user_id'=> rand(1,2),
            'vacancy' => rand(1,5),
            'job_location' => fake()->city,
            'description' => fake()->text,
            'experience' => rand(1, 10),
            'company_name' => fake()->name,
            'keywords' => implode(',', fake()->randomELements($keywordList, 1)),
        ];
    }
}
