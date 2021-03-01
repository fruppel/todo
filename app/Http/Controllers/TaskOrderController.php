<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskOrderController extends Controller
{
    public function update(Request $request)
    {
        $orderedTasks = array_merge(...array_values($request->get('tasks')));
        $tasks = Task::all()->where('user_id', '=', auth()->id());

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

        return response('Update successful');
    }
}
