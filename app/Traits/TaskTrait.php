<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait TaskTrait
{
    public function getTask($project, int $id)
    {
        $task = $project->tasks()->find($id);

        if (!$task) {
            throw new HttpResponseException(
                response()->json(
                    ['errors' => [
                        'task' => [
                            "No task found with ID {$id} for the current project."
                        ],
                    ]],
                    404
                )
            );
        }

        return $task;
    }
}
