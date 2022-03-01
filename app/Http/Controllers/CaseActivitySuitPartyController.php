<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseActivitySuitPartyStoreRequest;
use App\Http\Requests\CaseActivitySuitPartyUpdateRequest;
use App\Http\Resources\CaseActivitySuitPartyCollection;
use App\Http\Resources\CaseActivitySuitPartyResource;
use App\Models\CaseActivitySuitParty;
use Illuminate\Http\Request;

class CaseActivitySuitPartyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CaseActivitySuitPartyCollection
     */
    public function index(Request $request)
    {
        $caseActivitySuitParties = CaseActivitySuitParty::with('suitParty', 'caseActivity')->latest()->get();

        return new CaseActivitySuitPartyCollection($caseActivitySuitParties);
    }

    /**
     * @param \App\Http\Requests\CaseActivitySuitPartyStoreRequest $request
     * @return \App\Http\Resources\CaseActivitySuitPartyResource
     */
    public function store(CaseActivitySuitPartyStoreRequest $request)
    {
        $caseActivitySuitParty = CaseActivitySuitParty::create($request->validated());

        return new CaseActivitySuitPartyResource($caseActivitySuitParty->load('suitParty', 'caseActivity'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseActivitySuitParty $caseActivitySuitParty
     * @return \App\Http\Resources\CaseActivitySuitPartyResource
     */
    public function show(Request $request, CaseActivitySuitParty $caseActivitySuitParty)
    {
        return new CaseActivitySuitPartyResource($caseActivitySuitParty->load('suitParty', 'caseActivity'));
    }

    /**
     * @param \App\Http\Requests\CaseActivitySuitPartyUpdateRequest $request
     * @param \App\Models\CaseActivitySuitParty $caseActivitySuitParty
     * @return \App\Http\Resources\CaseActivitySuitPartyResource
     */
    public function update(CaseActivitySuitPartyUpdateRequest $request, CaseActivitySuitParty $caseActivitySuitParty)
    {
        $caseActivitySuitParty->update($request->validated());

        return new CaseActivitySuitPartyResource($caseActivitySuitParty->load('suitParty', 'caseActivity'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseActivitySuitParty $caseActivitySuitParty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CaseActivitySuitParty $caseActivitySuitParty)
    {
        $caseActivitySuitParty->delete();

        return response()->noContent();
    }
}
