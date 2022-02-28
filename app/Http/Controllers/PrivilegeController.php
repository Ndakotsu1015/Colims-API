<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivilegeStoreRequest;
use App\Http\Requests\PrivilegeUpdateRequest;
use App\Http\Resources\PrivilegeCollection;
use App\Http\Resources\PrivilegeResource;
use App\Models\Privilege;
use Illuminate\Http\Request;

class PrivilegeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\PrivilegeCollection
     */
    public function index(Request $request)
    {
        $privileges = Privilege::latest()->get();

        return new PrivilegeCollection($privileges);
    }

    /**
     * @param \App\Http\Requests\PrivilegeStoreRequest $request
     * @return \App\Http\Resources\PrivilegeResource
     */
    public function store(PrivilegeStoreRequest $request)
    {
        $privilege = Privilege::create($request->validated());

        return new PrivilegeResource($privilege);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Privilege $privilege
     * @return \App\Http\Resources\PrivilegeResource
     */
    public function show(Request $request, Privilege $privilege)
    {
        return new PrivilegeResource($privilege);
    }

    /**
     * @param \App\Http\Requests\PrivilegeUpdateRequest $request
     * @param \App\Models\Privilege $privilege
     * @return \App\Http\Resources\PrivilegeResource
     */
    public function update(PrivilegeUpdateRequest $request, Privilege $privilege)
    {
        $privilege->update($request->validated());

        return new PrivilegeResource($privilege);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Privilege $privilege
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Privilege $privilege)
    {
        $privilege->delete();

        return response()->noContent();
    }
}
