<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Central\Project;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('creator', 'assignee')->latest()->paginate(10);
        return Inertia::render('Project/Index', ['projects' => $projects]);
    }

    public function create()
    {
        return Inertia::render('Project/Create');
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        Project::create($data);

        return redirect()->route('projects.index');
    }

    public function edit(Project $project)
    {
        return Inertia::render('Project/Edit', ['project' => $project]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        return redirect()->route('projects.index')->with('success', 'Project updated!');
    }


    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index');
    }
}
