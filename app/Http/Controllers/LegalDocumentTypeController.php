<?php

namespace App\Http\Controllers;

use App\Http\Requests\LegalDocumentTypeStoreRequest;
use App\Http\Requests\LegalDocumentTypeUpdateRequest;
use App\Http\Resources\LegalDocumentTypeCollection;
use App\Http\Resources\LegalDocumentTypeResource;
use App\Models\LegalDocumentType;
use Illuminate\Http\Request;

class LegalDocumentTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\LegalDocumentTypeCollection
     */
    public function index(Request $request)
    {
        $legalDocumentTypes = LegalDocumentType::latest()->get();

        return new LegalDocumentTypeCollection($legalDocumentTypes);
    }

    /**
     * @param \App\Http\Requests\LegalDocumentTypeStoreRequest $request
     * @return \App\Http\Resources\LegalDocumentTypeResource
     */
    public function store(LegalDocumentTypeStoreRequest $request)
    {
        $legalDocumentType = LegalDocumentType::create($request->validated());

        return new LegalDocumentTypeResource($legalDocumentType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LegalDocumentType $legalDocumentType
     * @return \App\Http\Resources\LegalDocumentTypeResource
     */
    public function show(Request $request, LegalDocumentType $legalDocumentType)
    {
        return new LegalDocumentTypeResource($legalDocumentType);
    }

    /**
     * @param \App\Http\Requests\LegalDocumentTypeUpdateRequest $request
     * @param \App\Models\LegalDocumentType $legalDocumentType
     * @return \App\Http\Resources\LegalDocumentTypeResource
     */
    public function update(LegalDocumentTypeUpdateRequest $request, LegalDocumentType $legalDocumentType)
    {
        $legalDocumentType->update($request->validated());

        return new LegalDocumentTypeResource($legalDocumentType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LegalDocumentType $legalDocumentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, LegalDocumentType $legalDocumentType)
    {
        $legalDocumentType->delete();

        return response()->noContent();
    }
}
