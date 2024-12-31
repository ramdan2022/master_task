<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponse;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::get();

        return ApiResponse::send_response(200, 'first response', TaskResource::collection($tasks));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(TaskRequest $request)
    {
        // validate request
        $Validated = $request->validated();

        $project = Project::where('name', '=', $Validated->project_name)->first();

        // create new task =========
        $task = Task::create([
            'Title' => $request->title,
            'Descreption' => $request->descreption,
            'project_id' => $project->id
        ]);

        // return response ==========
        if ($task) {
            return ApiResponse::send_response(201, 'create sueccfully', []);
        } else {
            return ApiResponse::send_response(500, 'Did not create', []);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $task = Task::where('id', '=', $id)->first();
        $task = Task::findOrFail($id);

        if ($task) {

            $res = $task->update([

                'Status'  => $request->Status,


            ]);
        } else {
            $res = false;
        }


        if (! $res) {
            return ApiResponse::send_response(501, 'Did not updated', []);
        } else {
            // return single resource record by new taskResource($task)
            return ApiResponse::send_response(201, 'updated succfully', new TaskResource($task));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);

        $res = $task->delete();

        if ($res) {
            return ApiResponse::send_response(200, 'task is delete', []);
        } else {
            return ApiResponse::send_response(501, 'Did not deleted', []);
        }
    }
}
