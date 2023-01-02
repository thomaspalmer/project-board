<?php

namespace Database\Factories;

use App\Enums\Vendors;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Source>
 */
class SourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'vendor' => $vendor = $this->faker->randomElement(Vendors::cases())->value,
            'active' => $this->faker->boolean(),
            'credentials' => $this->generateCredentials($vendor),

        ];
    }

    /**
     * @param string $vendor
     * @return array
     */
    private function generateCredentials(string $vendor): array
    {
        return match ($vendor) {
            'active-collab' => [
                'email' => $this->faker->email(),
                'password' => $this->faker->password(),
                'company_name' => $this->faker->company(),
                'account_number' => $this->faker->numberBetween(10000, 99999)
            ],
            'github' => [
                'personal_oauth_token' => Str::random(),
                'expires_at' => $this->faker->dateTimeBetween(now(), now()->addYears(2)),
            ],
        };
    }
}
