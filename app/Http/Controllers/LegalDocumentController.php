<?php

namespace App\Http\Controllers;

use App\Http\Requests\LegalDocumentStoreRequest;
use App\Http\Requests\LegalDocumentUpdateRequest;
use App\Http\Resources\LegalDocumentCollection;
use App\Http\Resources\LegalDocumentResource;
use App\Models\LegalDocument;
use Illuminate\Http\Request;

class LegalDocumentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\LegalDocumentCollection
     */
    public function index(Request $request)
    {
        $legalDocuments = LegalDocument::with('courtCase', 'user', 'documentType')->get();

        return new LegalDocumentCollection($legalDocuments);
    }

    /**
     * @param \App\Http\Requests\LegalDocumentStoreRequest $request
     * @return \App\Http\Resources\LegalDocumentResource
     */
    public function store(LegalDocumentStoreRequest $request)
    {
        $legalDocument = LegalDocument::create($request->validated());

        return new LegalDocumentResource($legalDocument->load('courtCase', 'user', 'documentType'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LegalDocument $legalDocument
     * @return \App\Http\Resources\LegalDocumentResource
     */
    public function show(Request $request, LegalDocument $legalDocument)
    {
        return new LegalDocumentResource($legalDocument);
    }

    /**
     * @param \App\Http\Requests\LegalDocumentUpdateRequest $request
     * @param \App\Models\LegalDocument $legalDocument
     * @return \App\Http\Resources\LegalDocumentResource
     */
    public function update(LegalDocumentUpdateRequest $request, LegalDocument $legalDocument)
    {
        $legalDocument->update($request->validated());

        return new LegalDocumentResource($legalDocument->load('courtCase', 'user', 'documentType'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LegalDocument $legalDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, LegalDocument $legalDocument)
    {
        $legalDocument->delete();

        return response()->noContent();
    }
}
