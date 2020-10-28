<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskCompleteController extends Controller
{
    public function store(Task $task)
    {
        $this->authorize('complete', $task);

        return new TaskResource($task->complete());
    }
}
