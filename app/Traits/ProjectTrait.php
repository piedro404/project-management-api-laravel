<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait ProjectTrait
{
    public function getProject($user, int $id)
    {
        $project = $user->projects()->find($id);

        if (!$project) {
            throw new HttpResponseException(
                response()->json(
                    ['errors' => [
                        'project' => [
                            "No project found with ID {$id} for the current user."
                        ],
                    ]],
                    404
                )
            );
        }

        return $project;
    }
}
