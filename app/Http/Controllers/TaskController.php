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

        Task::create(request()->all() + ['user_id' => auth()->id()]);

        return Redirect::route('tasks.index');

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('flash', 'Aufgabe erstellt');
    }

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

    public function updateFinished(Task $task)
    {
        $task->finished = request()->get('finished');
        $task->save();

        return response('Update successful', 200);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response('Task deleted', 200);
    }
}
