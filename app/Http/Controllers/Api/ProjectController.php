<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateProjectRequest;
use App\Models\Project;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return response()->json([
            'projects' => $projects
        ]);
    }

    public function store(CreateProjectRequest $request)
    {
        $inputData = array_merge($request->validated(), ['uuid' => (string) Str::orderedUuid()]);
        Project::create($inputData);
        return response()->json(['message' => 'The project is created successfully.'], Response::HTTP_CREATED);
    }

    public function show(Project $project)
    {
        return response()->json([
            'project' => $project
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json([
            'message' =>'The project is deleted successfully.'
        ]);
    }
}
