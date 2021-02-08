<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function index(): Response
    {
        $todo = Task::whereFinished(false)
            ->whereUserId(auth()->id())
            ->orderBy('day', 'asc')
            ->orderBy('order', 'asc')
            ->get()
            ->groupBy('day');

        $archived = Task::whereFinished(true)
            ->whereUserId(auth()->id())
            ->orderBy('day', 'desc')
            ->orderBy('order', 'asc')
            ->get()
            ->groupBy('day');;

        return Inertia::render('Tasks/Index', [
            'todo' => $todo,
            'archived' => $archived,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Tasks/Create');
    }

    public function edit(Task $task): Response
    {
        return Inertia::render('Tasks/Edit', compact('task'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'description' => 'required',
            'day' => 'required',
        ])->validateWithBag('storeTask');

//        request()->validate([
//            'description' => 'required',
//            'day' => 'required',
//        ]);

        Task::create(request()->all() + ['user_id' => auth()->id()]);

        return Redirect::route('tasks.index');

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('flash', 'Aufgabe erstellt');

//        return redirect()
//            ->route('tasks.index')
//            ->with('flash', 'Aufgabe erstellt');
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
            ->with('flash', 'Aufgabe aktualisiert');
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
