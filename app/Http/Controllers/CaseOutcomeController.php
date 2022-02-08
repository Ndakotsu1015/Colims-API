<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseOutcomeStoreRequest;
use App\Http\Requests\CaseOutcomeUpdateRequest;
use App\Http\Resources\CaseOutcomeCollection;
use App\Http\Resources\CaseOutcomeResource;
use App\Models\CaseOutcome;
use Illuminate\Http\Request;

class CaseOutcomeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CaseOutcomeCollection
     */
    public function index(Request $request)
    {
        $caseOutcomes = CaseOutcome::all();

        return new CaseOutcomeCollection($caseOutcomes);
    }

    /**
     * @param \App\Http\Requests\CaseOutcomeStoreRequest $request
     * @return \App\Http\Resources\CaseOutcomeResource
     */
    public function store(CaseOutcomeStoreRequest $request)
    {
        $caseOutcome = CaseOutcome::create($request->validated());

        return new CaseOutcomeResource($caseOutcome);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseOutcome $caseOutcome
     * @return \App\Http\Resources\CaseOutcomeResource
     */
    public function show(Request $request, CaseOutcome $caseOutcome)
    {
        return new CaseOutcomeResource($caseOutcome);
    }

    /**
     * @param \App\Http\Requests\CaseOutcomeUpdateRequest $request
     * @param \App\Models\CaseOutcome $caseOutcome
     * @return \App\Http\Resources\CaseOutcomeResource
     */
    public function update(CaseOutcomeUpdateRequest $request, CaseOutcome $caseOutcome)
    {
        $caseOutcome->update($request->validated());

        return new CaseOutcomeResource($caseOutcome);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseOutcome $caseOutcome
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CaseOutcome $caseOutcome)
    {
        $caseOutcome->delete();

        return response()->noContent();
    }
}
