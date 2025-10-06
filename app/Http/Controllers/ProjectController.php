<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Js;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     * @return JsonResponse
     * $todo Consider pagination of results and selecting specific fields to return as data set grows
     */
    public function index(): JsonResponse
    {
        return new ProjectCollection(Project::all())->response()->setStatusCode(200);
    }

    /**
     * Store a newly created project
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Add other fields as needed
        ]);

        $project = Project::create($validated);

        return new ProjectResource($project)->response()->setStatusCode(201);
    }

    /**
     * Display the specified project
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $project = Project::findOrFail($id);
        return new ProjectResource($project)->response()->setStatusCode(200);
    }
}
