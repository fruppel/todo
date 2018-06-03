<?php

namespace App\Http\Controllers;

use App\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todo = Task::whereFinished(false)
            ->orderBy('day', 'asc')
            ->orderBy('order', 'asc')
            ->get()
            ->groupBy('day');

        $archived = Task::whereFinished(true)
            ->orderBy('day', 'desc')
            ->orderBy('order', 'asc')
            ->get()
            ->groupBy('day');;


        return view('tasks.index', compact('todo', 'archived'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'description' => 'required',
            'day' => 'required',
        ]);

        Task::create(request()->all());

        return redirect()->route('tasks.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Task $task)
    {
        request()->validate([
            'description' => 'required',
            'day' => 'required',
        ]);

        $task->update(request()->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated');
    }

    /**
     * Updates the ordering of all tasks
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function updateOrder()
    {
        // Make a flat array
        $orderedTasks = call_user_func_array('array_merge', request()->get('tasks'));

        $tasks = Task::all();

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

    public function updateFinished(Task $task)
    {
        $task->finished = request()->get('finished');
        $task->save();

        return response('Update successful', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response('Task deleted', 200);
    }
}
