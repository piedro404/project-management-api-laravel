<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = User::find(auth('api')->user()->id);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $project_id)
    {
        return $this->user->projects->find($project_id)->tasks()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request, int $project_id)
    {
        $this->user->projects->find($project_id)->tasks()->create($request->all());

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
        if (!$task = $this->user->projects->find($project_id)->tasks()->find($id)) {
            return response()->json(
                [
                    'errors' =>
                    [
                        'task' =>
                        [
                            "No task found with ID {$id} for the current project."
                        ],
                    ]
                ],
                404
            );
        }

        return $task;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, int $project_id, int $id)
    {
        if (!$task = $this->user->projects->find($project_id)->tasks()->find($id)) {
            return response()->json(
                [
                    'errors' =>
                    [
                        'task' =>
                        [
                            "No task found with ID {$id} for the current project."
                        ],
                    ]
                ],
                404
            );
        }

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
        if (!$task = $this->user->projects->find($project_id)->tasks()->find($id)) {
            return response()->json(
                [
                    'errors' =>
                    [
                        'task' =>
                        [
                            "No task found with ID {$id} for the current project."
                        ],
                    ]
                ],
                404
            );
        }

        $task->delete();

        return response()->json(
            ['message' => 'Successfully delete tasks'],
            201
        );
    }
}
