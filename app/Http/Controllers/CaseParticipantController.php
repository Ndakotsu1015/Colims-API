<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseParticipantStoreRequest;
use App\Http\Requests\CaseParticipantUpdateRequest;
use App\Http\Resources\CaseParticipantCollection;
use App\Http\Resources\CaseParticipantResource;
use App\Models\CaseParticipant;
use Illuminate\Http\Request;

class CaseParticipantController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CaseParticipantCollection
     */
    public function index(Request $request)
    {
        $caseParticipants = CaseParticipant::latest()->get();

        return new CaseParticipantCollection($caseParticipants);
    }

    /**
     * @param \App\Http\Requests\CaseParticipantStoreRequest $request
     * @return \App\Http\Resources\CaseParticipantResource
     */
    public function store(CaseParticipantStoreRequest $request)
    {
        $caseParticipant = CaseParticipant::create($request->validated());

        return new CaseParticipantResource($caseParticipant);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseParticipant $caseParticipant
     * @return \App\Http\Resources\CaseParticipantResource
     */
    public function show(Request $request, CaseParticipant $caseParticipant)
    {
        return new CaseParticipantResource($caseParticipant);
    }

    /**
     * @param \App\Http\Requests\CaseParticipantUpdateRequest $request
     * @param \App\Models\CaseParticipant $caseParticipant
     * @return \App\Http\Resources\CaseParticipantResource
     */
    public function update(CaseParticipantUpdateRequest $request, CaseParticipant $caseParticipant)
    {
        $caseParticipant->update($request->validated());

        return new CaseParticipantResource($caseParticipant);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseParticipant $caseParticipant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CaseParticipant $caseParticipant)
    {
        $caseParticipant->delete();

        return response()->noContent();
    }
}
