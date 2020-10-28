<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return TaskResource::collection(Task::mine()->latest()->get());
    }

    public function store()
    {
        $task = auth()->user()->tasks()->create(
            request()->validate([
                'title' => 'required'
            ])
        );

        return new TaskResource($task);
    }
}
