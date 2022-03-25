<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractDocumentTypeStoreRequest;
use App\Http\Requests\ContractDocumentTypeUpdateRequest;
use App\Http\Resources\ContractDocumentTypeCollection;
use App\Http\Resources\ContractDocumentTypeResource;
use App\Models\ContractDocumentType;
use Illuminate\Http\Request;

class ContractDocumentTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ContractDocumentTypeCollection
     */
    public function index(Request $request)
    {
        $contractDocumentTypes = ContractDocumentType::all();

        return new ContractDocumentTypeCollection($contractDocumentTypes);
    }

    /**
     * @param \App\Http\Requests\ContractDocumentTypeStoreRequest $request
     * @return \App\Http\Resources\ContractDocumentTypeResource
     */
    public function store(ContractDocumentTypeStoreRequest $request)
    {
        $contractDocumentType = ContractDocumentType::create($request->validated());

        return new ContractDocumentTypeResource($contractDocumentType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractDocumentType $contractDocumentType
     * @return \App\Http\Resources\ContractDocumentTypeResource
     */
    public function show(Request $request, ContractDocumentType $contractDocumentType)
    {
        return new ContractDocumentTypeResource($contractDocumentType);
    }

    /**
     * @param \App\Http\Requests\ContractDocumentTypeUpdateRequest $request
     * @param \App\Models\ContractDocumentType $contractDocumentType
     * @return \App\Http\Resources\ContractDocumentTypeResource
     */
    public function update(ContractDocumentTypeUpdateRequest $request, ContractDocumentType $contractDocumentType)
    {
        $contractDocumentType->update($request->validated());

        return new ContractDocumentTypeResource($contractDocumentType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractDocumentType $contractDocumentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ContractDocumentType $contractDocumentType)
    {
        $contractDocumentType->delete();

        return response()->noContent();
    }
}
