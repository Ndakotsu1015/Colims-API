<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseDraftSuitPartyStoreRequest;
use App\Http\Requests\CaseDraftSuitPartyUpdateRequest;
use App\Http\Resources\CaseDraftSuitPartyCollection;
use App\Http\Resources\CaseDraftSuitPartyResource;
use App\Models\CaseDraftSuitParty;
use Illuminate\Http\Request;

class CaseDraftSuitPartyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CaseDraftSuitPartyCollection
     */
    public function index(Request $request)
    {
        $caseDraftSuitParties = CaseDraftSuitParty::all();

        return new CaseDraftSuitPartyCollection($caseDraftSuitParties);
    }

    /**
     * @param \App\Http\Requests\CaseDraftSuitPartyStoreRequest $request
     * @return \App\Http\Resources\CaseDraftSuitPartyResource
     */
    public function store(CaseDraftSuitPartyStoreRequest $request)
    {
        $caseDraftSuitParty = CaseDraftSuitParty::create($request->validated());

        return new CaseDraftSuitPartyResource($caseDraftSuitParty);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseDraftSuitParty $caseDraftSuitParty
     * @return \App\Http\Resources\CaseDraftSuitPartyResource
     */
    public function show(Request $request, CaseDraftSuitParty $caseDraftSuitParty)
    {
        return new CaseDraftSuitPartyResource($caseDraftSuitParty);
    }

    /**
     * @param \App\Http\Requests\CaseDraftSuitPartyUpdateRequest $request
     * @param \App\Models\CaseDraftSuitParty $caseDraftSuitParty
     * @return \App\Http\Resources\CaseDraftSuitPartyResource
     */
    public function update(CaseDraftSuitPartyUpdateRequest $request, CaseDraftSuitParty $caseDraftSuitParty)
    {
        $caseDraftSuitParty->update($request->validated());

        return new CaseDraftSuitPartyResource($caseDraftSuitParty);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseDraftSuitParty $caseDraftSuitParty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CaseDraftSuitParty $caseDraftSuitParty)
    {
        $caseDraftSuitParty->delete();

        return response()->noContent();
    }
}
