<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\EmployeeCollection
     */
    public function index(Request $request)
    {
        $employees = Employee::all();

        return new EmployeeCollection($employees);
    }

    /**
     * @param \App\Http\Requests\EmployeeStoreRequest $request
     * @return \App\Http\Resources\EmployeeResource
     */
    public function store(EmployeeStoreRequest $request)
    {
        $employee = Employee::create($request->validated());

        return new EmployeeResource($employee);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \App\Http\Resources\EmployeeResource
     */
    public function show(Request $request, Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    /**
     * @param \App\Http\Requests\EmployeeUpdateRequest $request
     * @param \App\Models\Employee $employee
     * @return \App\Http\Resources\EmployeeResource
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        return new EmployeeResource($employee);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Employee $employee)
    {
        $employee->delete();

        return response()->noContent();
    }
}
