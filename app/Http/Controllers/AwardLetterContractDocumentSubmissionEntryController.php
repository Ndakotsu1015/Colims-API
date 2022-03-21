<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardLetterContractDocumentSubmissionEntryStoreRequest;
use App\Http\Requests\AwardLetterContractDocumentSubmissionEntryUpdateRequest;
use App\Http\Resources\AwardLetterContractDocumentSubmissionEntryCollection;
use App\Http\Resources\AwardLetterContractDocumentSubmissionEntryResource;
use App\Models\AwardLetterContractDocumentSubmissionEntry;
use Illuminate\Http\Request;

class AwardLetterContractDocumentSubmissionEntryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\AwardLetterContractDocumentSubmissionEntryCollection
     */
    public function index(Request $request)
    {
        $awardLetterContractDocumentSubmissionEntries = AwardLetterContractDocumentSubmissionEntry::all();

        return new AwardLetterContractDocumentSubmissionEntryCollection($awardLetterContractDocumentSubmissionEntries);
    }

    /**
     * @param \App\Http\Requests\AwardLetterContractDocumentSubmissionEntryStoreRequest $request
     * @return \App\Http\Resources\AwardLetterContractDocumentSubmissionEntryResource
     */
    public function store(AwardLetterContractDocumentSubmissionEntryStoreRequest $request)
    {
        $awardLetterContractDocumentSubmissionEntry = AwardLetterContractDocumentSubmissionEntry::create($request->validated());

        return new AwardLetterContractDocumentSubmissionEntryResource($awardLetterContractDocumentSubmissionEntry);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetterContractDocumentSubmissionEntry $awardLetterContractDocumentSubmissionEntry
     * @return \App\Http\Resources\AwardLetterContractDocumentSubmissionEntryResource
     */
    public function show(Request $request, AwardLetterContractDocumentSubmissionEntry $awardLetterContractDocumentSubmissionEntry)
    {
        return new AwardLetterContractDocumentSubmissionEntryResource($awardLetterContractDocumentSubmissionEntry);
    }

    /**
     * @param \App\Http\Requests\AwardLetterContractDocumentSubmissionEntryUpdateRequest $request
     * @param \App\Models\AwardLetterContractDocumentSubmissionEntry $awardLetterContractDocumentSubmissionEntry
     * @return \App\Http\Resources\AwardLetterContractDocumentSubmissionEntryResource
     */
    public function update(AwardLetterContractDocumentSubmissionEntryUpdateRequest $request, AwardLetterContractDocumentSubmissionEntry $awardLetterContractDocumentSubmissionEntry)
    {
        $awardLetterContractDocumentSubmissionEntry->update($request->validated());

        return new AwardLetterContractDocumentSubmissionEntryResource($awardLetterContractDocumentSubmissionEntry);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetterContractDocumentSubmissionEntry $awardLetterContractDocumentSubmissionEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AwardLetterContractDocumentSubmissionEntry $awardLetterContractDocumentSubmissionEntry)
    {
        $awardLetterContractDocumentSubmissionEntry->delete();

        return response()->noContent();
    }
}
