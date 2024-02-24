<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $user = User::factory()->create();

        return [
            'user_id' => $user->id,
            'date' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+1 week')->format('Y-m-d'),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time()
        ];
    }
}
