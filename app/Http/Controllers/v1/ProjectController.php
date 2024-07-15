<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\AuthenticatedController;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\{
    ProjectCollectionResource,
    ProjectResource,
};
use App\Http\Resources\ProjectReportResource;
use App\Traits\ProjectTrait;

class ProjectController extends AuthenticatedController
{
    use ProjectTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProjectCollectionResource::collection($this->user->projects()->get()->load('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $this->user->projects()->create($request->all());

        return response()->json(
            ['message' => 'Successfully created project'],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $project = $this->getProject($this->user, $id)->load('tasks');

        return response()->json(
            new ProjectResource($project),
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, int $id)
    {
        $project = $this->getProject($this->user, $id);

        $project->update($request->all());

        return response()->json(
            ['message' => 'Successfully update project'],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $project = $this->getProject($this->user, $id);

        $project->delete();

        return response()->json(
            ['message' => 'Successfully delete project'],
            204
        );
    }

    public function report(int $id)
    {
        $project = $this->getProject($this->user, $id)->load('tasks')->load('user');

        return response()->json(
            new ProjectReportResource($project),
            200
        );
    }
}
