<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractTypeStoreRequest;
use App\Http\Requests\ContractTypeUpdateRequest;
use App\Http\Resources\ContractTypeCollection;
use App\Http\Resources\ContractTypeResource;
use App\Models\ContractType;
use Illuminate\Http\Request;

class ContractTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ContractTypeCollection
     */
    public function index(Request $request)
    {
        $contractTypes = ContractType::latest()->get();

        return new ContractTypeCollection($contractTypes);
    }

    /**
     * @param \App\Http\Requests\ContractTypeStoreRequest $request
     * @return \App\Http\Resources\ContractTypeResource
     */
    public function store(ContractTypeStoreRequest $request)
    {
        $contractType = ContractType::create($request->validated());

        return new ContractTypeResource($contractType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractType $contractType
     * @return \App\Http\Resources\ContractTypeResource
     */
    public function show(Request $request, ContractType $contractType)
    {
        return new ContractTypeResource($contractType);
    }

    /**
     * @param \App\Http\Requests\ContractTypeUpdateRequest $request
     * @param \App\Models\ContractType $contractType
     * @return \App\Http\Resources\ContractTypeResource
     */
    public function update(ContractTypeUpdateRequest $request, ContractType $contractType)
    {
        $contractType->update($request->validated());

        return new ContractTypeResource($contractType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractType $contractType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ContractType $contractType)
    {
        $contractType->delete();

        return response()->noContent();
    }
}
