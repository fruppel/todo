<?php

namespace App\Http\Controllers;

use App\Models\Task;

class TaskOrderController extends Controller
{
    public function update()
    {
        $orderedTasks = call_user_func_array('array_merge', request()->get('tasks'));
        $tasks = Task::whereUserId(auth()->id())->get();

        foreach ($tasks as $task) {
            $task->timestamps = false;

            foreach ($orderedTasks as $orderedTask) {
                if ($orderedTask['id'] === $task->id) {
                    $task->update([
                        'order' => $orderedTask['order'],
                        'day' => $orderedTask['day'],
                    ]);
                }
            }
        }

        return response('Update successful', 200);
    }
}
