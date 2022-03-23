<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseDraftStoreRequest;
use App\Http\Requests\CaseDraftUpdateRequest;
use App\Http\Resources\CaseDraftCollection;
use App\Http\Resources\CaseDraftResource;
use App\Models\CaseDraft;
use Illuminate\Http\Request;

class CaseDraftController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CaseDraftCollection
     */
    public function index(Request $request)
    {
        $caseDrafts = CaseDraft::all();

        return new CaseDraftCollection($caseDrafts);
    }

    /**
     * @param \App\Http\Requests\CaseDraftStoreRequest $request
     * @return \App\Http\Resources\CaseDraftResource
     */
    public function store(CaseDraftStoreRequest $request)
    {
        $caseDraft = CaseDraft::create($request->validated());

        return new CaseDraftResource($caseDraft);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseDraft $caseDraft
     * @return \App\Http\Resources\CaseDraftResource
     */
    public function show(Request $request, CaseDraft $caseDraft)
    {
        return new CaseDraftResource($caseDraft);
    }

    /**
     * @param \App\Http\Requests\CaseDraftUpdateRequest $request
     * @param \App\Models\CaseDraft $caseDraft
     * @return \App\Http\Resources\CaseDraftResource
     */
    public function update(CaseDraftUpdateRequest $request, CaseDraft $caseDraft)
    {
        $caseDraft->update($request->validated());

        return new CaseDraftResource($caseDraft);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseDraft $caseDraft
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CaseDraft $caseDraft)
    {
        $caseDraft->delete();

        return response()->noContent();
    }
}
