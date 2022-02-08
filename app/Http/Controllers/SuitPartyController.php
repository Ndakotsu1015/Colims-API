<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuitPartyStoreRequest;
use App\Http\Requests\SuitPartyUpdateRequest;
use App\Http\Resources\SuitPartyCollection;
use App\Http\Resources\SuitPartyResource;
use App\Models\SuitParty;
use Illuminate\Http\Request;

class SuitPartyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\SuitPartyCollection
     */
    public function index(Request $request)
    {
        $suitParties = SuitParty::with('courtCase')->get();

        return new SuitPartyCollection($suitParties);
    }

    /**
     * @param \App\Http\Requests\SuitPartyStoreRequest $request
     * @return \App\Http\Resources\SuitPartyResource
     */
    public function store(SuitPartyStoreRequest $request)
    {
        $suitParty = SuitParty::create($request->validated());

        return new SuitPartyResource($suitParty->load('courtCase'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SuitParty $suitParty
     * @return \App\Http\Resources\SuitPartyResource
     */
    public function show(Request $request, SuitParty $suitParty)
    {
        return new SuitPartyResource($suitParty->load('courtCase'));
    }

    /**
     * @param \App\Http\Requests\SuitPartyUpdateRequest $request
     * @param \App\Models\SuitParty $suitParty
     * @return \App\Http\Resources\SuitPartyResource
     */
    public function update(SuitPartyUpdateRequest $request, SuitParty $suitParty)
    {
        $suitParty->update($request->validated());

        return new SuitPartyResource($suitParty->load('courtCase'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SuitParty $suitParty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SuitParty $suitParty)
    {
        $suitParty->delete();

        return response()->noContent();
    }
}
