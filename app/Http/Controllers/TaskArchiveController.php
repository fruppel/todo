<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;

class TaskArchiveController extends Controller
{
    public function index()
    {
        $archived = Task::whereFinished(true)
            ->whereUserId(auth()->id())
            ->orderBy('day', 'desc')
            ->orderBy('order', 'asc')
            ->get()
            ->groupBy('day');

        return Inertia::render('Tasks/Archive/Index', [
            'archived' => $archived,
        ]);
    }
}
