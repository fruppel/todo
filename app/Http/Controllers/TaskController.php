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
            ->orderBy('day', 'asc')
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
        Validator::make($request->all(), [
            'description' => 'required',
            'day' => 'required',
        ])->validateWithBag('storeTask');

        Task::create(request()->all() + ['user_id' => auth()->id()]);

        return Redirect::route('tasks.index');
    }

    public function update(Task $task, Request $request)
    {
        $validatedRequest = $request->validate([
            'description' => 'required',
            'day' => 'required',
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
