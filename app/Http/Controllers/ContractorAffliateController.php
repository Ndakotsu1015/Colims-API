<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractorAffliateStoreRequest;
use App\Http\Requests\ContractorAffliateUpdateRequest;
use App\Http\Resources\ContractorAffliateCollection;
use App\Http\Resources\ContractorAffliateResource;
use App\Models\ContractorAffliate;
use Illuminate\Http\Request;

class ContractorAffliateController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ContractorAffliateCollection
     */
    public function index(Request $request)
    {
        $contractorAffliates = ContractorAffliate::with('bank', 'contractor')->get();

        return new ContractorAffliateCollection($contractorAffliates);
    }

    /**
     * @param \App\Http\Requests\ContractorAffliateStoreRequest $request
     * @return \App\Http\Resources\ContractorAffliateResource
     */
    public function store(ContractorAffliateStoreRequest $request)
    {
        $contractorAffliate = ContractorAffliate::create($request->validated());

        return new ContractorAffliateResource($contractorAffliate->load('bank', 'contractor'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractorAffliate $contractorAffliate
     * @return \App\Http\Resources\ContractorAffliateResource
     */
    public function show(Request $request, ContractorAffliate $contractorAffliate)
    {
        return new ContractorAffliateResource($contractorAffliate->load('bank', 'contractor'));
    }

    /**
     * @param \App\Http\Requests\ContractorAffliateUpdateRequest $request
     * @param \App\Models\ContractorAffliate $contractorAffliate
     * @return \App\Http\Resources\ContractorAffliateResource
     */
    public function update(ContractorAffliateUpdateRequest $request, ContractorAffliate $contractorAffliate)
    {
        $contractorAffliate->update($request->validated());

        return new ContractorAffliateResource($contractorAffliate->load('bank', 'contractor'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractorAffliate $contractorAffliate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ContractorAffliate $contractorAffliate)
    {
        $contractorAffliate->delete();

        return response()->noContent();
    }
}
