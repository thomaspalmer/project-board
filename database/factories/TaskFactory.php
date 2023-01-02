<?php

namespace Database\Factories;

use App\Enums\Priorities;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => '<p>' . $this->faker->paragraph() . '</p>',
            'priority' => $this->faker->randomElement(Priorities::cases())->value,
            'due_at' => $dueAt = $this->faker->dateTimeBetween(now(), now()->addYear()),
            'completed_at' => $this->faker->boolean ? $this->faker->dateTimeBetween($dueAt, Carbon::parse($dueAt)->addYear()) : null,
            'link' => $this->faker->url(),
            'external_id' => Str::random(),
        ];
    }
}
