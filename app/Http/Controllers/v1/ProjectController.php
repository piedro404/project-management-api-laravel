<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = User::find(auth('api')->user()->id);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->user->projects()->get();
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
        if (!$project = $this->user->projects()->find($id)) {
            return response()->json(
                [
                    'errors' =>
                    [
                        'project' =>
                        [
                            "No project found with ID {$id} for the current user."
                        ],
                    ]
                ],
                404
            );
        }

        return $project;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->user->projects()->create($request->all());

        return response()->json(
            ['message' => 'Successfully created project'],
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
