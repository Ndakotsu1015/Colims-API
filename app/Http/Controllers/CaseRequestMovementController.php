<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseRequestMovementStoreRequest;
use App\Http\Requests\CaseRequestMovementUpdateRequest;
use App\Http\Resources\CaseRequestMovementCollection;
use App\Http\Resources\CaseRequestMovementResource;
use App\Models\CaseRequestMovement;
use Illuminate\Http\Request;

class CaseRequestMovementController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CaseRequestMovementCollection
     */
    public function index(Request $request)
    {
        $caseRequestMovements = CaseRequestMovement::with('caseRequest', 'forwardTo', 'user')->get();

        return new CaseRequestMovementCollection($caseRequestMovements);
    }

    /**
     * @param \App\Http\Requests\CaseRequestMovementStoreRequest $request
     * @return \App\Http\Resources\CaseRequestMovementResource
     */
    public function store(CaseRequestMovementStoreRequest $request)
    {
        $caseRequestMovement = CaseRequestMovement::create($request->validated());

        return new CaseRequestMovementResource($caseRequestMovement->load('caseRequest', 'forwardTo', 'user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseRequestMovement $caseRequestMovement
     * @return \App\Http\Resources\CaseRequestMovementResource
     */
    public function show(Request $request, CaseRequestMovement $caseRequestMovement)
    {
        return new CaseRequestMovementResource($caseRequestMovement->load('caseRequest', 'forwardTo', 'user'));
    }

    /**
     * @param \App\Http\Requests\CaseRequestMovementUpdateRequest $request
     * @param \App\Models\CaseRequestMovement $caseRequestMovement
     * @return \App\Http\Resources\CaseRequestMovementResource
     */
    public function update(CaseRequestMovementUpdateRequest $request, CaseRequestMovement $caseRequestMovement)
    {
        $caseRequestMovement->update($request->validated());

        return new CaseRequestMovementResource($caseRequestMovement->load('caseRequest', 'forwardTo', 'user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseRequestMovement $caseRequestMovement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CaseRequestMovement $caseRequestMovement)
    {
        $caseRequestMovement->delete();

        return response()->noContent();
    }
}
