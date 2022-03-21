<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardLetterContractDocumentSubmissionStoreRequest;
use App\Http\Requests\AwardLetterContractDocumentSubmissionUpdateRequest;
use App\Http\Resources\AwardLetterContractDocumentSubmissionCollection;
use App\Http\Resources\AwardLetterContractDocumentSubmissionResource;
use App\Models\AwardLetterContractDocumentSubmission;
use Illuminate\Http\Request;

class AwardLetterContractDocumentSubmissionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\AwardLetterContractDocumentSubmissionCollection
     */
    public function index(Request $request)
    {
        $awardLetterContractDocumentSubmissions = AwardLetterContractDocumentSubmission::all();

        return new AwardLetterContractDocumentSubmissionCollection($awardLetterContractDocumentSubmissions);
    }

    /**
     * @param \App\Http\Requests\AwardLetterContractDocumentSubmissionStoreRequest $request
     * @return \App\Http\Resources\AwardLetterContractDocumentSubmissionResource
     */
    public function store(AwardLetterContractDocumentSubmissionStoreRequest $request)
    {
        $awardLetterContractDocumentSubmission = AwardLetterContractDocumentSubmission::create($request->validated());

        return new AwardLetterContractDocumentSubmissionResource($awardLetterContractDocumentSubmission);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetterContractDocumentSubmission $awardLetterContractDocumentSubmission
     * @return \App\Http\Resources\AwardLetterContractDocumentSubmissionResource
     */
    public function show(Request $request, AwardLetterContractDocumentSubmission $awardLetterContractDocumentSubmission)
    {
        return new AwardLetterContractDocumentSubmissionResource($awardLetterContractDocumentSubmission);
    }

    /**
     * @param \App\Http\Requests\AwardLetterContractDocumentSubmissionUpdateRequest $request
     * @param \App\Models\AwardLetterContractDocumentSubmission $awardLetterContractDocumentSubmission
     * @return \App\Http\Resources\AwardLetterContractDocumentSubmissionResource
     */
    public function update(AwardLetterContractDocumentSubmissionUpdateRequest $request, AwardLetterContractDocumentSubmission $awardLetterContractDocumentSubmission)
    {
        $awardLetterContractDocumentSubmission->update($request->validated());

        return new AwardLetterContractDocumentSubmissionResource($awardLetterContractDocumentSubmission);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetterContractDocumentSubmission $awardLetterContractDocumentSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AwardLetterContractDocumentSubmission $awardLetterContractDocumentSubmission)
    {
        $awardLetterContractDocumentSubmission->delete();

        return response()->noContent();
    }
}
