<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractorStoreRequest;
use App\Http\Requests\ContractorUpdateRequest;
use App\Http\Resources\ContractorCollection;
use App\Http\Resources\ContractorResource;
use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContractorController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ContractorCollection
     */
    public function index(Request $request)
    {
        $contractors = Contractor::all();

        return new ContractorCollection($contractors);
    }

    /**
     * @param \App\Http\Requests\ContractorStoreRequest $request
     * @return \App\Http\Resources\ContractorResource
     */
    public function store(ContractorStoreRequest $request)
    // public function store(Request $request)
    {

        Log::debug($request->all());
        $contractor = Contractor::create($request->validated());

        return new ContractorResource($contractor);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Contractor $contractor
     * @return \App\Http\Resources\ContractorResource
     */
    public function show(Request $request, Contractor $contractor)
    {
        return new ContractorResource($contractor);
    }

    /**
     * @param \App\Http\Requests\ContractorUpdateRequest $request
     * @param \App\Models\Contractor $contractor
     * @return \App\Http\Resources\ContractorResource
     */
    public function update(ContractorUpdateRequest $request, Contractor $contractor)
    {
        $contractor->update($request->validated());

        return new ContractorResource($contractor);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Contractor $contractor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Contractor $contractor)
    {
        $contractor->delete();

        return response()->noContent();
    }
}
