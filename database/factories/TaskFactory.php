<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory {
    protected $model = Task::class;

    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'day' => $this->faker->dateTimeBetween('yesterday', '+8 days')->format('Y-m-d'),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
