<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractDocumentSubmissionEntryStoreRequest;
use App\Http\Requests\ContractDocumentSubmissionEntryUpdateRequest;
use App\Http\Resources\ContractDocumentSubmissionEntryCollection;
use App\Http\Resources\ContractDocumentSubmissionEntryResource;
use App\Models\ContractDocumentSubmissionEntry;
use Illuminate\Http\Request;

class ContractDocumentSubmissionEntryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ContractDocumentSubmissionEntryCollection
     */
    public function index(Request $request)
    {
        $ContractDocumentSubmissionEntries = ContractDocumentSubmissionEntry::all();

        return new ContractDocumentSubmissionEntryCollection($ContractDocumentSubmissionEntries);
    }

    /**
     * @param \App\Http\Requests\ContractDocumentSubmissionEntryStoreRequest $request
     * @return \App\Http\Resources\ContractDocumentSubmissionEntryResource
     */
    public function store(ContractDocumentSubmissionEntryStoreRequest $request)
    {
        $ContractDocumentSubmissionEntry = ContractDocumentSubmissionEntry::create($request->validated());

        return new ContractDocumentSubmissionEntryResource($ContractDocumentSubmissionEntry);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractDocumentSubmissionEntry $ContractDocumentSubmissionEntry
     * @return \App\Http\Resources\ContractDocumentSubmissionEntryResource
     */
    public function show(Request $request, ContractDocumentSubmissionEntry $ContractDocumentSubmissionEntry)
    {
        return new ContractDocumentSubmissionEntryResource($ContractDocumentSubmissionEntry);
    }

    /**
     * @param \App\Http\Requests\ContractDocumentSubmissionEntryUpdateRequest $request
     * @param \App\Models\ContractDocumentSubmissionEntry $ContractDocumentSubmissionEntry
     * @return \App\Http\Resources\ContractDocumentSubmissionEntryResource
     */
    public function update(ContractDocumentSubmissionEntryUpdateRequest $request, ContractDocumentSubmissionEntry $ContractDocumentSubmissionEntry)
    {
        $ContractDocumentSubmissionEntry->update($request->validated());

        return new ContractDocumentSubmissionEntryResource($ContractDocumentSubmissionEntry);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractDocumentSubmissionEntry $ContractDocumentSubmissionEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ContractDocumentSubmissionEntry $ContractDocumentSubmissionEntry)
    {
        $ContractDocumentSubmissionEntry->delete();

        return response()->noContent();
    }
}
