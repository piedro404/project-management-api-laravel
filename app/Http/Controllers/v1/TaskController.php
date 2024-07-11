<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\AuthenticatedController;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Traits\{
    ProjectTrait,
    TaskTrait,
};

class TaskController extends AuthenticatedController
{
    use ProjectTrait;
    use TaskTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(int $project_id)
    {
        $project = $this->getProject($this->user, $project_id);

        return TaskResource::collection($project->tasks);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request, int $project_id)
    {
        $project = $this->getProject($this->user, $project_id);

        $project->tasks()->create($request->all());

        return response()->json(
            ['message' => 'Successfully created tasks'],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $project_id, int $id)
    {
        $project = $this->getProject($this->user, $project_id);
        $task = $this->getTask($project, $id);

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, int $project_id, int $id)
    {
        $project = $this->getProject($this->user, $project_id);
        $task = $this->getTask($project, $id);

        $task->update($request->all());

        return response()->json(
            ['message' => 'Successfully update tasks'],
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $project_id, int $id)
    {
        $project = $this->getProject($this->user, $project_id);
        $task = $this->getTask($project, $id);

        $task->delete();

        return response()->json(
            ['message' => 'Successfully delete tasks'],
            204
        );
    }
}
