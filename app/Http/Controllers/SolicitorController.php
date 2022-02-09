<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitorStoreRequest;
use App\Http\Requests\SolicitorUpdateRequest;
use App\Http\Resources\SolicitorCollection;
use App\Http\Resources\SolicitorResource;
use App\Models\Solicitor;
use Illuminate\Http\Request;

class SolicitorController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\SolicitorCollection
     */
    public function index(Request $request)
    {
        $solicitors = Solicitor::with('state')->get();

        return new SolicitorCollection($solicitors);
    }

    /**
     * @param \App\Http\Requests\SolicitorStoreRequest $request
     * @return \App\Http\Resources\SolicitorResource
     */
    public function store(SolicitorStoreRequest $request)
    {
        $solicitor = Solicitor::create($request->validated());

        return new SolicitorResource($solicitor->load('state'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Solicitor $solicitor
     * @return \App\Http\Resources\SolicitorResource
     */
    public function show(Request $request, Solicitor $solicitor)
    {
        return new SolicitorResource($solicitor->load('state'));
    }

    /**
     * @param \App\Http\Requests\SolicitorUpdateRequest $request
     * @param \App\Models\Solicitor $solicitor
     * @return \App\Http\Resources\SolicitorResource
     */
    public function update(SolicitorUpdateRequest $request, Solicitor $solicitor)
    {
        $solicitor->update($request->validated());

        return new SolicitorResource($solicitor->load('state'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Solicitor $solicitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Solicitor $solicitor)
    {
        $solicitor->delete();

        return response()->noContent();
    }
}
