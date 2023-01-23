<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ProjectResource;
use App\Models\Employee;
use App\Models\Project;
use http\Client\Response;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(EmployeeResource::collection(Employee::query()->with('companies', 'projects')->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->save();

        return response([new EmployeeResource($employee),
            "You can attach existing projects to employee ID with post request to",
            "/api/v1/employees/{$employee->id}/attachProject/{projectID} route and vice versa with detachProject"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return response(new EmployeeResource($employee->load('companies', 'projects')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->name = $request->name;
        $employee->update();

        return response(['Employee data updated', new EmployeeResource($employee)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response(['Employee deleted', new EmployeeResource($employee)]);
    }

    /**
     * Attach the specified resource to storage.
     *
     * @param  object $employee
     * @param  object $project
     * @return \Illuminate\Http\Response
     */
    public function attachProject(Employee $employee, Project $project): Response
    {
        $employee->projects()->attach($project);

        return \response([new EmployeeResource($employee), "attached to project :", new ProjectResource($project)]);
    }

    /**
     * Detach the specified resource to storage.
     *
     * @param  object $employee
     * @param  object $project
     * @return \Illuminate\Http\Response
     */
    public function detachProject(Employee $employee, Project $project): Response
    {
        $employee->projects()->detach($project);

        return \response([new ProjectResource($employee), 'detached from project :', new ProjectResource($project)]);
    }
}
