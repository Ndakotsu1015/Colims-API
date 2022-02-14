<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourtCaseStoreRequest;
use App\Http\Requests\CourtCaseUpdateRequest;
use App\Http\Resources\CourtCaseCollection;
use App\Http\Resources\CourtCaseResource;
use App\Models\CourtCase;
use Illuminate\Http\Request;

class CourtCaseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CourtCaseCollection
     */
    public function index(Request $request)
    {
        $courtCases = CourtCase::with('handler', 'postedBy', 'caseStatus', 'caseOutcome', 'solicitor', 'caseRequest')->get();

        return new CourtCaseCollection($courtCases);
    }

    /**
     * @param \App\Http\Requests\CourtCaseStoreRequest $request
     * @return \App\Http\Resources\CourtCaseResource
     */
    public function store(CourtCaseStoreRequest $request)
    {
        $courtCase = CourtCase::create($request->validated());

        return new CourtCaseResource($courtCase->load('handler', 'postedBy', 'caseStatus', 'caseOutcome', 'solicitor', 'caseRequest'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CourtCase $courtCase
     * @return \App\Http\Resources\CourtCaseResource
     */
    public function show(Request $request, CourtCase $courtCase)
    {
        return new CourtCaseResource($courtCase->load('handler', 'postedBy', 'caseStatus', 'caseOutcome', 'solicitor', 'caseRequest'));
    }

    /**
     * @param \App\Http\Requests\CourtCaseUpdateRequest $request
     * @param \App\Models\CourtCase $courtCase
     * @return \App\Http\Resources\CourtCaseResource
     */
    public function update(CourtCaseUpdateRequest $request, CourtCase $courtCase)
    {
        $courtCase->update($request->validated());

        return new CourtCaseResource($courtCase->load('handler', 'postedBy', 'caseStatus', 'caseOutcome', 'solicitor', 'caseRequest'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CourtCase $courtCase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CourtCase $courtCase)
    {
        $courtCase->delete();

        return response()->noContent();
    }
}
