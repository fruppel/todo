<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        $todo = Task::whereFinished(false)
            ->whereUserId(auth()->id())
            ->orderByRaw('if(day is null,1,0), day asc')
            ->orderBy('order', 'asc')
            ->get()
            ->groupBy('day');

        return Inertia::render('Tasks/Index', [
            'todo' => $todo,
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
        $validatedRequest = Validator::make($request->all(), [
            'description' => 'required',
            'day' => '',
        ])->validateWithBag('storeTask');

        Task::create($validatedRequest + ['user_id' => auth()->id()]);

        return Redirect::route('tasks.index');
    }

    public function update(Task $task, Request $request)
    {
        $validatedRequest = $request->validate([
            'description' => 'required',
            'day' => ''
        ]);

        $task->update($validatedRequest);

        return redirect()->route('tasks.index')
            ->with('flash', 'Todo aktualisiert');
    }

    public function updateFinished(Task $task, Request $request)
    {
        $task->finished = $request->get('finished');

        if ($task->save() === true) {
            return response('Update successful');
        }

        throw new \Exception('Task could not be saved');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response('Task deleted');
    }
}
