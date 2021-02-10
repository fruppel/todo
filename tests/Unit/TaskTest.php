<?php

namespace Tests\Unit;

use App\Models\Task;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_task_can_be_created()
    {
        $data = [
            'description' => 'My task',
            'day' => Carbon::now()->format('Y-m-d')
        ];

        $task = Task::factory($data)->create();

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals($data['description'], $task->description);
        $this->assertEquals($data['day'], $task->day);
    }

}
