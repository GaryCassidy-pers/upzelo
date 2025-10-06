<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks
     * @return JsonResponse
     * $todo Consider pagination of results and selecting specific fields to return as data set grows
     */
    public function index()
    {
        return new TaskCollection(Task::all())->response()->setStatusCode(200);
    }

    /**
     * Store a newly created task
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = Task::create($validated);

        return new TaskResource($task)->response()->setStatusCode(201);
    }

    /**
     * Display the specified task
     * @param Request $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return new TaskResource($task)->response()->setStatusCode(200);
    }
}
