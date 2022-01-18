<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivilegeClassStoreRequest;
use App\Http\Requests\PrivilegeClassUpdateRequest;
use App\Http\Resources\PrivilegeClassCollection;
use App\Http\Resources\PrivilegeClassResource;
use App\Models\PrivilegeClass;
use Illuminate\Http\Request;

class PrivilegeClassController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\PrivilegeClassCollection
     */
    public function index(Request $request)
    {
        $privilegeClasses = PrivilegeClass::all();

        return new PrivilegeClassCollection($privilegeClasses);
    }

    /**
     * @param \App\Http\Requests\PrivilegeClassStoreRequest $request
     * @return \App\Http\Resources\PrivilegeClassResource
     */
    public function store(PrivilegeClassStoreRequest $request)
    {
        $privilegeClass = PrivilegeClass::create($request->validated());

        return new PrivilegeClassResource($privilegeClass);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PrivilegeClass $privilegeClass
     * @return \App\Http\Resources\PrivilegeClassResource
     */
    public function show(Request $request, PrivilegeClass $privilegeClass)
    {
        return new PrivilegeClassResource($privilegeClass);
    }

    /**
     * @param \App\Http\Requests\PrivilegeClassUpdateRequest $request
     * @param \App\Models\PrivilegeClass $privilegeClass
     * @return \App\Http\Resources\PrivilegeClassResource
     */
    public function update(PrivilegeClassUpdateRequest $request, PrivilegeClass $privilegeClass)
    {
        $privilegeClass->update($request->validated());

        return new PrivilegeClassResource($privilegeClass);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PrivilegeClass $privilegeClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PrivilegeClass $privilegeClass)
    {
        $privilegeClass->delete();

        return response()->noContent();
    }
}
