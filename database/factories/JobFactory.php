<?php

namespace Database\Factories;

use Carbon\Carbon;
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
    public function definition()
    {
        return [
            'user_id' => 1,
            'title' => $this->faker->title(),
            'companyName' => $this->faker->company(),
            'description' => nl2br($this->faker->realText()),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'expirationDate' => Carbon::now()->addDays(7),
            'status' => 1
        ];
    }
}
