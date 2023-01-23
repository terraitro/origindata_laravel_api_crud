<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\ProjectResource;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(ProjectResource::collection(Project::query()->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $project = new Project();
        $project->name = $request->name;
        $project->save();

        return response([new ProjectResource($project),
            "You can attach existing companies to project ID with post request to",
            "/api/v1/projects/{$project->id}/attachCompany/{companyID} route and vice versa with detachCompany"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response(new ProjectResource($project));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->name = $request->name;
        $project->update();

        return response(['Project data updated', new ProjectResource($project)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response(['Project deleted', new ProjectResource($project)]);
    }

    /**
     * Attach the specified resource to storage.
     *
     * @param  object $project
     * @param  object $company
     * @return \Illuminate\Http\Response
     */
    public function attachCompany(Project $project, Company $company): Response
    {
        $project->companies()->attach($company);

        return \response([new ProjectResource($project), "attached to company :", new CompanyResource($company)]);
    }

    /**
     * Detach the specified resource to storage.
     *
     * @param  object $project
     * @param  object $company
     * @return \Illuminate\Http\Response
     */
    public function detachCompany(Project $project, Company $company): Response
    {
        $project->companies()->detach($company);

        return \response([new ProjectResource($project), 'detached from company :', new CompanyResource($company)]);
    }
}
