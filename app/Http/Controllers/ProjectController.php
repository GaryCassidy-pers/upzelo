<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    // Display a listing of projects
    public function index()
    {
        return response()->json(Project::all());
    }

    // Store a newly created project
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Add other fields as needed
        ]);

        $project = Project::create($validated);

        return response()->json($project, 201);
    }

    // Display the specified project
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }
}
