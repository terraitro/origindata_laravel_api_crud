<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        #TODO implement pagination

        return response(CompanyResource::collection(Company::query()
            ->with('employees', 'projects')->get())
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request): Response
    {
        $company = new Company();
        $company->name = $request->name;
        $company->save();

        return response([new CompanyResource($company),
            "You can attach existing employees to company ID with post request to",
            "/api/v1/companies/{$company->id}/attachEmployee/{employeeID} route and vice versa with detachEmployee"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company): Response
    {
        return response(new CompanyResource($company->load('employees', 'projects')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCompanyRequest $request, Company $company): Response
    {
        $company->name = $request->name;
        $company->update();

        return response(['Company data updated', new CompanyResource($company)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  object $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company): Response
    {
       $company->delete();
       return response(['Company deleted', new CompanyResource($company)]);
    }

    /**
     * Attach the specified resource to storage.
     *
     * @param  object $company
     * @param  object $employee
     * @return \Illuminate\Http\Response
     */
    public function attachEmployee(Company $company, Employee $employee): Response
    {
        $company->employees()->attach($employee);

        return \response([new CompanyResource($company), "attached to employee :", new EmployeeResource($employee)]);
    }

    /**
     * Detach the specified resource to storage.
     *
     * @param  object $company
     * @param  object $employee
     * @return \Illuminate\Http\Response
     */
    public function detachEmployee(Company $company, Employee $employee): Response
    {
        $company->employees()->detach($employee);

        return \response([new CompanyResource($company), 'detached from employee :', new EmployeeResource($employee)]);
    }
}
