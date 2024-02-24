<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Work;

class BreakingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $work = Work::inRandomOrder()->first();
        if(!$work){
            $work = Work::factory()->create();
        }
        return [
            'user_id' => $work->user_id,
            'work_id' => $work->id,
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time()
        ];
    }
}
