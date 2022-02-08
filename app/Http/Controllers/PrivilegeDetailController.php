<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivilegeDetailStoreRequest;
use App\Http\Requests\PrivilegeDetailUpdateRequest;
use App\Http\Resources\PrivilegeDetailCollection;
use App\Http\Resources\PrivilegeDetailResource;
use App\Models\PrivilegeDetail;
use Illuminate\Http\Request;

class PrivilegeDetailController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\PrivilegeDetailCollection
     */
    public function index(Request $request)
    {
        $privilegeDetails = PrivilegeDetail::with('privilegeClass', 'user', 'privilege');

        return new PrivilegeDetailCollection($privilegeDetails);
    }

    /**
     * @param \App\Http\Requests\PrivilegeDetailStoreRequest $request
     * @return \App\Http\Resources\PrivilegeDetailResource
     */
    public function store(PrivilegeDetailStoreRequest $request)
    {
        $privilegeDetail = PrivilegeDetail::create($request->validated());

        return new PrivilegeDetailResource($privilegeDetail->load('privilegeClass', 'user', 'privilege'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PrivilegeDetail $privilegeDetail
     * @return \App\Http\Resources\PrivilegeDetailResource
     */
    public function show(Request $request, PrivilegeDetail $privilegeDetail)
    {
        return new PrivilegeDetailResource($privilegeDetail->load('privilegeClass', 'user', 'privilege'));
    }

    /**
     * @param \App\Http\Requests\PrivilegeDetailUpdateRequest $request
     * @param \App\Models\PrivilegeDetail $privilegeDetail
     * @return \App\Http\Resources\PrivilegeDetailResource
     */
    public function update(PrivilegeDetailUpdateRequest $request, PrivilegeDetail $privilegeDetail)
    {
        $privilegeDetail->update($request->validated());

        return new PrivilegeDetailResource($privilegeDetail->load('privilegeClass', 'user', 'privilege'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PrivilegeDetail $privilegeDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PrivilegeDetail $privilegeDetail)
    {
        $privilegeDetail->delete();

        return response()->noContent();
    }
}
