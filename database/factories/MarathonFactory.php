<?php

namespace Database\Factories;

use App\Models\Marathon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Marathon>
 */
class MarathonFactory extends Factory
{
    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(static function (Marathon $marathon) {
            $marathon->trainers()->sync([
                ['trainer_id' => 1],
                ['trainer_id' => 2],
                ['trainer_id' => 3],
            ]);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->paragraph(200),
            'start' => now(),
            'end' => now()->addDays(10)
        ];
    }
}
