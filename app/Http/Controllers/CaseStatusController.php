<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseStatusStoreRequest;
use App\Http\Requests\CaseStatusUpdateRequest;
use App\Http\Resources\CaseStatusCollection;
use App\Http\Resources\CaseStatusResource;
use App\Models\CaseStatus;
use Illuminate\Http\Request;

class CaseStatusController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CaseStatusCollection
     */
    public function index(Request $request)
    {
        $caseStatuses = CaseStatus::all();

        return new CaseStatusCollection($caseStatuses);
    }

    /**
     * @param \App\Http\Requests\CaseStatusStoreRequest $request
     * @return \App\Http\Resources\CaseStatusResource
     */
    public function store(CaseStatusStoreRequest $request)
    {
        $caseStatus = CaseStatus::create($request->validated());

        return new CaseStatusResource($caseStatus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseStatus $caseStatus
     * @return \App\Http\Resources\CaseStatusResource
     */
    public function show(Request $request, CaseStatus $caseStatus)
    {
        return new CaseStatusResource($caseStatus);
    }

    /**
     * @param \App\Http\Requests\CaseStatusUpdateRequest $request
     * @param \App\Models\CaseStatus $caseStatus
     * @return \App\Http\Resources\CaseStatusResource
     */
    public function update(CaseStatusUpdateRequest $request, CaseStatus $caseStatus)
    {
        $caseStatus->update($request->validated());

        return new CaseStatusResource($caseStatus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseStatus $caseStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CaseStatus $caseStatus)
    {
        $caseStatus->delete();

        return response()->noContent();
    }
}
