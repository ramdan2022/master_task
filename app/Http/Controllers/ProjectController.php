<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponse;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project = Project::get();

        if ($project) {
            return ApiResponse::send_response(200, 'project successful', ProjectResource::collection($project));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function set(ProjectRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', '=', $validated['Email'])->first();

        if ($user->cannot('create', Project::class)) {

            return ApiResponse::send_response(401, 'You are not authorize ya man', []);
        } else {


            $project = Project::create([
                'name'         => $validated['Name'],
                'Descreption'  => $validated['Descreption'],
                'user_id'      => $user->id

            ]);

            if ($project) {
                return ApiResponse::send_response(201, 'created successful', new ProjectResource($project));
            } else {
                return ApiResponse::send_response(400, 'Request not created');
            }
            // in next line the close bract for else(condition) to make sure the user is aurhorize 
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
        $project = Project::findOrFail($id);

        $res = $project->update([
            'name' => $request->name
        ]);

        if ($res) {
            return ApiResponse::send_response(201, 'updated successfully', new ProjectResource($project));
        } else {
            return ApiResponse::send_response(400, 'NOT Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {

        $project = Project::find($id);

        if ($project) {

            $res = $project->delete();

            if ($res) {
                return ApiResponse::send_response(200, 'deleted succssfully');
            } else {
                return ApiResponse::send_response(400, 'No content is deleted');
            }
        } else {

            return ApiResponse::send_response(400, 'This Project Not Found');
        }
    }
}
